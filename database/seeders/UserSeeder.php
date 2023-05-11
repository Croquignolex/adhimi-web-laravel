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
        $super_admin = User::factory()->create(['email' => 'super_admin@adhimi.com']);
        User::factory()->for($super_admin, 'creator')->create(['email' => 'user@adhimi.com']);
        $admin = User::factory()->for($super_admin, 'creator')->create(['email' => 'admin@adhimi.com']);
        $saler = User::factory()->for($super_admin, 'creator')->create(['email' => 'saler@adhimi.com']);
        $merchant = User::factory()->for($super_admin, 'creator')->create(['email' => 'merchant@adhimi.com']);
        $shop_manager = User::factory()->for($super_admin, 'creator')->create(['email' => 'shop_manager@adhimi.com']);

        $admin->syncRoles([Role::findOrCreate(UserRoleEnum::Admin->value, 'web')]);
        $saler->syncRoles([Role::findOrCreate(UserRoleEnum::Saler->value, 'web')]);
        $merchant->syncRoles([Role::findOrCreate(UserRoleEnum::Merchant->value, 'web')]);
        $super_admin->syncRoles([Role::findOrCreate(UserRoleEnum::SuperAdmin->value, 'web')]);
        $shop_manager->syncRoles([Role::findOrCreate(UserRoleEnum::ShopManager->value, 'web')]);
    }
}
