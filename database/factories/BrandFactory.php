<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\Brand;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => GeneralStatusEnum::randomValue(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
        ];
    }
}
