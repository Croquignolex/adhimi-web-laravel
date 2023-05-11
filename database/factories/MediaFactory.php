<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\MediaTypeEnum;
use App\Models\Media;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => MediaTypeEnum::randomValue(),
            'name' => fake()->name(),
            'url' => fake()->url(),
            'description' => $this->faker->text(),
        ];
    }
}
