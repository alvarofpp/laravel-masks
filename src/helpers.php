<?php

if (!function_exists('mask')) {
    /**
     * Applies mask in the value.
     *
     * @param string $mask
     * @param $value
     * @return string
     */
    function mask(string $mask, $value): string
    {
        if (is_null($value)) {
            return '';
        }
        $symbol = '#';

        // Apply mask
        $value = str_replace(" ", "", $value);
        $replacedStr = Illuminate\Support\Str::replaceArray($symbol, str_split($value), $mask);

        // Get filled substring
        $posSymbol = strpos($replacedStr, $symbol, strlen($value));
        $replacedStrLen = strlen($replacedStr);
        $length = $posSymbol ? $replacedStrLen - ($replacedStrLen - $posSymbol) : $replacedStrLen;

        return substr($replacedStr, 0, $length);
    }
}
