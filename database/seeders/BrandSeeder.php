<?php

namespace Database\Seeders;

use App\Enums\GeneralStatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Brand::factory()->create([
            'status' => GeneralStatusEnum::Enable,
            'name' => "No name",
        ]);
    }
}
