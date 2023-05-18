<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\Category;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
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
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->text(),
            'seo_title' => $this->faker->title(),
            'seo_description' => $this->faker->sentence,
        ];
    }
}
