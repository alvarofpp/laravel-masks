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

        $value = str_replace(" ", "", $value);
        $valueArray = str_split($value);
        return Illuminate\Support\Str::replaceArray('#', $valueArray, $mask);
    }
}
