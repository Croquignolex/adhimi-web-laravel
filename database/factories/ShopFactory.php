<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\Shop;

/**
 * @extends Factory<Shop>
 */
class ShopFactory extends Factory
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
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->text(),
            'status' => GeneralStatusEnum::randomValue(),
        ];
    }
}
