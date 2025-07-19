<?php

namespace App\Services;

use App\Models\Badword;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class BadwordFilterService
{
    protected static ?array $badwords = null;

    /**
     * Load bad words from cache or database.
     */
    public static function loadBadwords(): void
    {
        if (self::$badwords === null) {
            self::$badwords = Cache::remember('badwords_list_cache', now()->addMinutes(60), function () {
                return Badword::pluck('replacement', 'word')->toArray();
            });
        }
    }

    /**
     * Get the bad words list.
     */
    public static function getBadwords(): array
    {
        self::loadBadwords();
        return self::$badwords ?? [];
    }

    /**
     * Filter bad words from text.
     */
    public static function filter(string $text, bool $strict = true): string
    {
        $badwords = self::getBadwords();
        $useReplacements = config('larastart.replace_badwords', true);

        Log::debug('Filtering text', [
            'original_text' => $text,
            'replace_enabled' => $useReplacements,
            'badwords_loaded' => $badwords,
        ]);

        foreach ($badwords as $word => $replacement) {
            $pattern = $strict
                ? '/\b' . preg_quote($word, '/') . '\b/iu'
                : '/' . preg_quote($word, '/') . '/iu';

            Log::debug('Checking word', [
                'word' => $word,
                'replacement' => $replacement,
                'pattern' => $pattern,
            ]);

            $text = preg_replace_callback($pattern, function ($matches) use ($replacement, $useReplacements, $word) {
                $original = $matches[0];

                if ($useReplacements && $replacement !== null) {
                    // Preserve case
                    if (mb_strtoupper($original) === $original) {
                        $final = mb_strtoupper($replacement);
                    } elseif (mb_strtolower($original) === $original) {
                        $final = mb_strtolower($replacement);
                    } elseif (ucfirst(mb_strtolower($original)) === $original) {
                        $final = ucfirst(mb_strtolower($replacement));
                    } else {
                        $final = $replacement;
                    }

                    Log::debug('Replacing word with DB replacement', [
                        'matched' => $original,
                        'replacement_used' => $final,
                    ]);

                    return $final;
                }

                // Asterisk fallback
                $length = mb_strlen($original);
                if ($length <= 2) {
                    $final = str_repeat('*', $length);
                } else {
                    $final = mb_substr($original, 0, 1) .
                        str_repeat('*', $length - 2) .
                        mb_substr($original, -1);
                }

                Log::debug('Replacing word with asterisks', [
                    'matched' => $original,
                    'replacement_used' => $final,
                ]);

                return $final;
            }, $text);
        }

        Log::debug('Final filtered text', ['filtered_text' => $text]);

        return $text;
    }

    /**
     * Invalidate the cache and reset the static variable.
     */
    public static function invalidateCache(): void
    {
        Cache::forget('badwords_list_cache');
        self::$badwords = null;
    }
}
