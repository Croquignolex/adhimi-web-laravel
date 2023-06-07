<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Enums\UserStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $super_admin = User::factory()->create(['email' => 'super.admin@adhimi.com', 'status' => UserStatusEnum::Active, 'default_password' => false]);
        $super_admin->assignRole(Role::findOrCreate(UserRoleEnum::SuperAdmin->value));
    }
}
