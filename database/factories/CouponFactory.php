<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GeneralStatusEnum;
use App\Models\Coupon;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
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
            'code' => $this->faker->word(),
            'description' => $this->faker->text(),
            'discount' => $this->faker->randomNumber(2),
            'promotion_started_at' => now(),
            'promotion_ended_at' => now()->addMonths(),
        ];
    }
}
