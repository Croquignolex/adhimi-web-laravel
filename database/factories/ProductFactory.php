<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
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
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomNumber(1),
            'alert_quantity' => $this->faker->randomNumber(1),
            'delivery_price' => $this->faker->randomNumber(3),
            'sale_price' => $this->faker->randomNumber(4),
            'purchase_price' => $this->faker->randomNumber(4),
            'promotion_price' => $this->faker->randomNumber(3),
            'weight' => $this->faker->randomFloat(),
            'promotion_started_at' => now(),
            'promotion_ended_at' => now()->addMonths(),
        ];
    }
}
