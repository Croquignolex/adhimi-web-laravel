<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\LanguageEnum;
use App\Models\Setting;
use DateTimeZone;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'language' => LanguageEnum::randomValue(),
            'timezone' => collect(DateTimeZone::listIdentifiers())->random(),
        ];
    }
}
