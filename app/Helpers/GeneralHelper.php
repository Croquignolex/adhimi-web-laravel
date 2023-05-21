<?php

use Illuminate\Support\Facades\Route;

if(!function_exists('nullable_params_value'))
{
    /**
     * @param string $key
     * @param array $validated
     * @return string
     */
    function nullable_params_value(string $key, array $validated): string
    {
        $value = array_key_exists($key, $validated) ? $validated[$key] : '';
        return $value ?? '';
    }
}

if(!function_exists('enums_equals'))
{
    /**
     * @param mixed $itemOne
     * @param mixed $itemTwo
     * @param bool $compareKeys
     * @return bool
     */
    function enums_equals(mixed $itemOne, mixed $itemTwo, bool $compareKeys = false): bool
    {
        if($compareKeys) {
            return $itemOne?->name === $itemTwo?->name;
        }

        return $itemOne?->value === $itemTwo?->value;
    }
}

if(!function_exists('active_page'))
{
    /**
     * @param string $route
     * @param string $class
     * @return string
     */
    function active_page(string $route, string $class = 'active'): string
    {
        return (Route::is($route)) ? $class : '';
    }
}

if(!function_exists('text_format'))
{
    /**
     * @param string $text
     * @param int $maxCharacters
     * @return string
     */
    function text_format(string $text, int $maxCharacters): string
    {
        return (strlen($text) > $maxCharacters)
            ? mb_substr($text, 0, $maxCharacters, 'utf-8') . '...'
            : $text;
    }
}