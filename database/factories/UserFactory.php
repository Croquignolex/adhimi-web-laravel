<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\UserStatusEnum;
use App\Enums\GenderEnum;
use App\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'profession' => $this->faker->word,
            'address' => $this->faker->word,
            'gender' => GenderEnum::randomValue(),
            'email_verified_at' => now(),
            'description' => $this->faker->text(),
            'first_purchase' => $this->faker->boolean,
            'status' => UserStatusEnum::randomValue(),
            'birthdate' => now()->subYears(fake()->randomNumber(2)),
        ];
    }
}
