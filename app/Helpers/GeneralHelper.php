<?php

use Illuminate\Support\Facades\Route;

if(!function_exists('nullable_params_value'))
{
    /**
     * @param string $key
     * @param array $validated
     * @param bool $boolValue
     * @return string|bool
     */
    function nullable_params_value(string $key, array $validated, bool $boolValue = true): string|bool
    {
        $value = array_key_exists($key, $validated) ? $validated[$key] : '';

        if($boolValue) {
            return $value !== '';
        }

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

if(!function_exists('format_text'))
{
    /**
     * @param string $text
     * @param int $maxCharacters
     * @return string
     */
    function format_text(string $text, int $maxCharacters): string
    {
        return (strlen($text) > $maxCharacters)
            ? mb_substr($text, 0, $maxCharacters, 'utf-8') . '...'
            : $text;
    }
}

if(!function_exists('random_color'))
{
    /**
     * @param bool $hex
     * @return string
     */
    function random_color(bool $hex = false): string
    {
        if($hex) return '#FFFFFF';
        else return collect(['primary', 'info', 'warning', 'danger'])->random();
    }
}