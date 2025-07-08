<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

if(! function_exists('first_letter'))
{
    function first_letter($word)
    {
        return substr($word, 0, 1);
    }
}

if (!function_exists('format_post')) {
    function format_post($text, $limit = 200, $maxLines = 5) {
        // Remove excessive consecutive newlines
        $text = preg_replace("/(\r\n|\r|\n){3,}/", "\n\n", $text);

        // Convert new lines into an array to count them
        $lines = explode("\n", wordwrap($text, 80, "\n")); // Assumes approx. 80 chars per line
        $lineCount = count($lines);

        // Determine if truncation is needed based on length or line count
        $needsTruncation = strlen($text) > $limit || $lineCount > $maxLines;

        // If truncation is required, trim either by words or lines
        if ($needsTruncation) {
            // Truncate by characters first
            $truncatedText = substr($text, 0, $limit);

            // If still too many lines, truncate further
            $truncatedLines = explode("\n", wordwrap($truncatedText, 80, "\n"));
            if (count($truncatedLines) > $maxLines) {
                $truncatedText = implode("\n", array_slice($truncatedLines, 0, $maxLines)) . '...';
            }
            
            return [
                'short_text' => nl2br($truncatedText),
                'full_text' => nl2br($text),
                'truncated' => true
            ];
        }

        return [
            'short_text' => nl2br($text),
            'full_text' => nl2br($text),
            'truncated' => false
        ];
    }
}

if (!function_exists('replacePlaceholders')) {
    function replacePlaceholders(string $text, array $data): string
    {
        if (empty($text) || empty($data)) {
            return $text;
        }

        preg_match_all('/{(\w+)}/', $text, $matches);

        if (empty($matches[1])) {
            return $text;
        }

        foreach ($matches[1] as $field) {
            foreach ($data as $key => $value) {
                if (is_array($value) && isset($value[$field])) {
                    // e.g. $data['user']['username']
                    $text = str_replace("{{$field}}", $value[$field], $text);
                } elseif (is_object($value) && isset($value->{$field})) {
                    // e.g. $data['user']->username
                    $text = str_replace("{{$field}}", $value->{$field}, $text);
                } elseif ($key === $field) {
                    // direct scalar fields
                    $text = str_replace("{{$field}}", $value, $text);
                }
            }
        }

        return $text;
    }
}

if (!function_exists('formatNotificationText')) {
    function formatNotificationText(string $text, array $data): array
    {
        // First get the raw text with placeholders replaced
        $rawText = replacePlaceholders($text, $data);
        
        // For HTML formatting, we'll handle special cases
        $htmlText = $rawText;
        
        // Special case for user names, replace with links
        if (isset($data['user']) && isset($data['user']->username) && isset($data['user']->name)) {
            $userProfileUrl = route('profile.show', ['username' => $data['user']->username]);
            $userName = $data['user']->name;
            
            // Replace the name with a link to user profile
            $htmlText = str_replace(
                $userName, 
                '<a href="' . $userProfileUrl . '" class="text-primary-600 hover:underline">' . $userName . '</a>', 
                $htmlText
            );
        }
        
        return [
            'raw' => $rawText,
            'html' => $htmlText
        ];
    }
}

if (!function_exists('carbon_parse')) {
    /**
     * Return a Carbon instance or null for a date/time string or object.
     *
     * @param \DateTimeInterface|string|null $value
     * @return Carbon|null
     */
    function carbon_parse($value): ?Carbon
    {
        if (blank($value)) {
            return null;
        }

        try {
            return Carbon::make($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('str_plural')) {
    function str_plural($value, $count)
    {
        return Str::plural($value, $count);
    }
}