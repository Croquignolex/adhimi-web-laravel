<?php

namespace Database\Seeders;

use App\Enums\AttributeTypeEnum;
use App\Enums\GeneralStatusEnum;
use Illuminate\Database\Seeder;
use App\Models\AttributeValue;
use App\Models\Attribute;

class AttributeAndAttributesValuesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->build("Gender", AttributeTypeEnum::Select, [
                ['name' => "Male", 'value' => "M"],
                ['name' => "Female", 'value' => "F"],
                ['name' => "Mixte", 'value' => "MF"],
            ]
        );

        $this->build("Size", AttributeTypeEnum::Select, [
                ['name' => "Extra small", 'value' => "XS"],
                ['name' => "Small", 'value' => "S"],
                ['name' => "Medium", 'value' => "M"],
                ['name' => "Large", 'value' => "L"],
                ['name' => "Extra large", 'value' => "XL"],
                ['name' => "Extra extra large", 'value' => "XXL"]
            ]
        );

        $this->build("Color", AttributeTypeEnum::Color, [
                ['name' => "Black", 'value' => "#000000"],
                ['name' => "White", 'value' => "#ffffff"],
                ['name' => "yellow", 'value' => "#ffff00"],
                ['name' => "Green", 'value' => "#008000"],
                ['name' => "Blue", 'value' => "#0000ff"],
                ['name' => "Red", 'value' => "#ff0000"],
                ['name' => "Purple", 'value' => "#800080"],
                ['name' => "Pink", 'value' => "#ffc0cb"],
                ['name' => "Orange", 'value' => "#ffa400"],
                ['name' => "Brown", 'value' => "#a52a2a"]
            ]
        );
    }

    /**
     * @param string $name
     * @param AttributeTypeEnum $type
     * @param array $values
     * @return void
     */
    private function build(string $name, AttributeTypeEnum $type, array $values): void
    {
        $attribute = Attribute::factory()->create([
            'status' => GeneralStatusEnum::Enable,
            'type' => $type->value,
            'name' => $name,
        ]);

        foreach ($values as $value)
        {
            AttributeValue::factory()->for($attribute)->create([
                'status' => GeneralStatusEnum::Enable,
                'name' => $value['name'],
                'value' => $value['value']
            ]);
        }
    }
}
