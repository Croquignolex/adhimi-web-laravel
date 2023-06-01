<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\AddressTypeEnum;
use App\Models\Address;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_address' => $this->faker->streetName(),
            'street_address_plus' => $this->faker->streetAddress(),
            'zipcode' => $this->faker->postcode(),
            'phone_number_one' => $this->faker->phoneNumber(),
            'phone_number_two' => $this->faker->phoneNumber(),
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'description' => $this->faker->text(),
            'type' => AddressTypeEnum::randomValue(),
        ];
    }
}
