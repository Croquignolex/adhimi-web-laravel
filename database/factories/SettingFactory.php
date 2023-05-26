<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\LanguageEnum;
use App\Models\Setting;
use DateTimeZone;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'language' => LanguageEnum::randomValue(),
            'timezone' => collect(DateTimeZone::listIdentifiers())->random(),

            'enable_action_on_super_admin_notification' => $this->faker->boolean,
            'enable_action_on_admin_notification' => $this->faker->boolean,
            'enable_action_on_manager_notification' => $this->faker->boolean,
            'enable_action_on_merchant_notification' => $this->faker->boolean,
            'enable_action_on_saler_notification' => $this->faker->boolean,
            'enable_action_on_customer_notification' => $this->faker->boolean,

            'enable_product_notification' => $this->faker->boolean,
            'enable_purchase_notification' => $this->faker->boolean,
            'enable_payment_notification' => $this->faker->boolean,
        ];
    }
}
