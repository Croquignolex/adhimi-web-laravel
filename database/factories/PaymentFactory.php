<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Payment;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomNumber(),
            'status' => PaymentStatusEnum::randomValue(),
            'phone' => $this->faker->phoneNumber(),
            'provider' => PaymentProviderEnum::randomValue(),
            'data' => json_encode([["transaction" => $this->faker->word()]]),
        ];
    }
}
