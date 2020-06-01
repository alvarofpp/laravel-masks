<?php

if (!function_exists('mask')) {
    /**
     * Applies mask in the value.
     *
     * @param string $mask
     * @param string $value
     * @return string
     */
    function mask(string $mask, string $value): string
    {
        $value = str_replace(" ", "", $value);
        $valueArray = str_split($value);
        return Illuminate\Support\Str::replaceArray('#', $valueArray, $mask);
    }
}
