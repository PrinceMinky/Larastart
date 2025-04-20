<?php

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