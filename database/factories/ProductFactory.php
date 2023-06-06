<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\DistanceValueEnum;
use App\Enums\QuantityValueEnum;
use App\Enums\GeneralStatusEnum;
use App\Enums\WeightValueEnum;
use App\Models\Product;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
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
            'sku' => $this->faker->unique()->word,
            'barcode' => $this->faker->unique()->randomNumber(),
            'description' => $this->faker->text(),
            'min_price' => $this->faker->randomNumber(3),
            'max_price' => $this->faker->randomNumber(3),
            'weight' => $this->faker->randomFloat(),
            'seo_title' => $this->faker->title(),
            'seo_description' => $this->faker->sentence,
            'weight_value' => $this->faker->randomFloat(),
            'weight_unit' => WeightValueEnum::randomValue(),
            'height_value' => $this->faker->randomFloat(),
            'height_unit' => DistanceValueEnum::randomValue(),
            'width_value' => $this->faker->randomFloat(),
            'width_unit' => DistanceValueEnum::randomValue(),
            'depth_value' => $this->faker->randomFloat(),
            'depth_unit' => DistanceValueEnum::randomValue(),
            'volume_value' => $this->faker->randomFloat(),
            'volume_unit' => QuantityValueEnum::randomValue(),
        ];
    }
}
