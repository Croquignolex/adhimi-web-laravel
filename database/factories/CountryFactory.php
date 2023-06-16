<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\Country;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_code' => $this->faker->randomNumber(),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'name' => $this->faker->country(),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->text(),
        ];
    }
}
