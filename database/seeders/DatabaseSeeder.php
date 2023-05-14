<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AttributeAndAttributesValuesSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(UserSeeder::class);
    }
}
