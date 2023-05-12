<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\AttributeTypeEnum;
use App\Enums\GeneralStatusEnum;
use App\Models\Attribute;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
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
            'type' => AttributeTypeEnum::randomValue(),
            'description' => $this->faker->text(),
            'status' => GeneralStatusEnum::randomValue(),
        ];
    }
}
