<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organisation;

class OrganisationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Organisation::factory()->create([
            'name' => config('app.name'),
            'email' => 'contact@adhimi.com',
            'website' => 'https://adhimi.com/',
            'phone' => '+237 692 31 93 41',
        ]);
    }
}
