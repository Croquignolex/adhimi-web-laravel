<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organisation;

/**
 * @extends Factory<Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name(),
            'slug' => $this->faker->unique()->slug,
            'email' => $this->faker->safeEmail(),
            'website' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->text(),
        ];
    }
}
