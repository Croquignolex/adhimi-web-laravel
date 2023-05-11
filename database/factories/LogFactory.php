<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\LogActionEnum;
use App\Models\Log;

/**
 * @extends Factory<Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'action' => LogActionEnum::randomValue(),
            'description' => $this->faker->text()
        ];
    }
}
