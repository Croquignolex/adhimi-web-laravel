<?php

namespace App\Observers;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Traits\UniqueFieldTrait;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Str;
use App\Enums\UserRoleEnum;
use App\Models\User;

class UserObserver
{
    use UniqueFieldTrait;

    /**
     * Handle the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user): void
    {
        $user->password = Hash::make($user->password ?? config('app.default_password'));
        $user->remember_token = Str::random(60);
        $user->username = Str::slug($user->name);
        $user->status = UserStatusEnum::Active;
    }

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        $user->syncRoles([Role::findOrCreate(UserRoleEnum::User->value, 'web')]);

        $user->setting()->create();
    }
}
