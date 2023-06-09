<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\State;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'slug' => $this->faker->unique()->slug,
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'description' => $this->faker->text(),
            'status' => GeneralStatusEnum::randomValue(),
        ];
    }
}
