<?php

namespace App\Traits;

trait EnumToolsTrait
{
    /**
     * Transform enum manes to array
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Transform enum values to array
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Transform enum manes to array keys & values to array values
     *
     * @return array
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * Get a random value form enum values
     *
     * @return mixed
     */
    public static function randomValue(): mixed
    {
        $values = self::values();
        $random_Key = array_rand($values);

        return $values[$random_Key];
    }

    /**
     * Get validation string
     *
     * @return mixed
     */
    public static function validationRule(): string
    {
        $inValues = implode(',', self::values());
        return "string|in:$inValues";
    }
}
