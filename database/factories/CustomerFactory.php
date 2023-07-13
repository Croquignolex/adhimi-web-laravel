<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GenderEnum;
use App\Models\Customer;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'slug' => $this->faker->unique()->slug(),
            'email' => $this->faker->unique()->safeEmail(),
            'profession' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'gender' => GenderEnum::randomValue(),
            'email_verified_at' => now(),
            'description' => $this->faker->text(),
            'first_purchase' => $this->faker->boolean,
            'birthdate' => now()->subYears(fake()->randomNumber(2)),
        ];
    }
}
