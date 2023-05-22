<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
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
        $super_admin = User::factory()->create(['email' => 'super.admin@adhimi.com']);
        $admin = User::factory()->for($super_admin, 'creator')->create(['email' => 'admin@adhimi.com']);
        $saler = User::factory()->for($super_admin, 'creator')->create(['email' => 'saler@adhimi.com']);
        $merchant = User::factory()->for($super_admin, 'creator')->create(['email' => 'merchant@adhimi.com']);
        $customer = User::factory()->for($super_admin, 'creator')->create(['email' => 'customer@adhimi.com']);
        $shop_manager = User::factory()->for($super_admin, 'creator')->create(['email' => 'shop.manager@adhimi.com']);

        $admin->assignRole(Role::findOrCreate(UserRoleEnum::Admin->value));
        $saler->assignRole(Role::findOrCreate(UserRoleEnum::Saler->value));
        $customer->assignRole(Role::findOrCreate(UserRoleEnum::Customer->value));
        $merchant->assignRole(Role::findOrCreate(UserRoleEnum::Merchant->value));
        $super_admin->assignRole(Role::findOrCreate(UserRoleEnum::SuperAdmin->value));
        $shop_manager->assignRole(Role::findOrCreate(UserRoleEnum::ShopManager->value));
    }
}
