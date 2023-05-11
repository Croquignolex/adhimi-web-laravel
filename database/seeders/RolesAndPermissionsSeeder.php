<?php

namespace Database\Seeders;

use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Enums\UserRoleEnum;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Create new roles
        foreach (UserRoleEnum::values() as $role) {
            Role::findOrCreate($role);
        }

        //Delete old roles
        foreach (Role::all() as $role) {
            if (!in_array($role->name, UserRoleEnum::values(), true)) {
                $role->delete();
            }
        }

        $adminRole = Role::findByName(UserRoleEnum::Admin->value);
        $adminRole->givePermissionTo(Permission::all());
    }
}
