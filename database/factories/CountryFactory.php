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
            'phone_extension' => $this->faker->randomNumber(),
            'code' => $this->faker->countryCode(),
            'name' => $this->faker->country(),
            'status' => GeneralStatusEnum::randomValue(),
        ];
    }
}
