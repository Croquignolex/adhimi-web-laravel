<?php

namespace Database\Seeders;

use App\Enums\GeneralStatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Group;

class GroupsAndCategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->build("Informatique", "it", [
                ['name' => "Ordinateur", 'seo' => "computer"],
                ['name' => "Imprimantes", 'seo' => "printer"],
                ['name' => "Stockage", 'seo' => "storage"],
                ['name' => "Scanneur", 'seo' => "scanner"],
            ]
        );

        $this->build("Beauté", "beauty", [
                ['name' => "Huile corporel", 'seo' => "body_oil"],
                ['name' => "Parfum", 'seo' => "perfume"],
                ['name' => "Savon", 'seo' => "soap"],
            ]
        );

        $this->build("Santé", "health", [
                ['name' => "Complément alimentaire", 'seo' => "dietary_supplement"],
                ['name' => "Vitamines", 'seo' => "vitamins"],
            ]
        );

        $this->build("Sport", "sport", [
                ['name' => "Maillot", 'seo' => "jersey"],
                ['name' => "Ballon", 'seo' => "ball"],
            ]
        );

        $this->build("Mode", "fashion", [
                ['name' => "Enfant", 'seo' => "child"],
                ['name' => "Femme", 'seo' => "woman"],
                ['name' => "Homme", 'seo' => "man"],

            ]
        );

        $this->build("Sécurité", "security", [
                ['name' => "Camera", 'seo' => "camara"],
                ['name' => "Alarme", 'seo' => "alarm"],
            ]
        );

        $this->build("Electronique", "electronic", [
                ['name' => "Télévision", 'seo' => "television"],
                ['name' => "Hoofer", 'seo' => "hoofer"],
            ]
        );

        $this->build("Jeux video", "gaming", [
                ['name' => "Console de jeux", 'seo' => "game_console"],
                ['name' => "PC gamer", 'seo' => "gaming_pc"],
            ]
        );

        $this->build("Téléphone", "phone", [
                ['name' => "Smartphone", 'seo' => "smartphone"],
                ['name' => "Tablette", 'seo' => "tablette"],
            ]
        );
    }

    /**
     * @param string $name
     * @param string $seo
     * @param array $values
     * @return void
     */
    private function build(string $name, string $seo, array $values): void
    {
        $group = Group::factory()->create([
            'status' => GeneralStatusEnum::Enable,
            'name' => $name,
            'description' => $name,
            'seo_title' => $seo,
            'seo_description' => "$seo group",
        ]);

        foreach ($values as $value)
        {
            Category::factory()->for($group)->create([
                'status' => GeneralStatusEnum::Enable,
                'name' => $value['name'],
                'description' => $value['name'],
                'seo_title' => $value['seo'],
                'seo_description' => $value['seo'] . " group",
            ]);
        }
    }
}
