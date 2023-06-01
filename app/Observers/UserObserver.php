<?php

namespace App\Observers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user): void
    {
        $user->password = Hash::make($user->password ?: config('app.default_password'));
        $user->remember_token = Str::random(60);
    }

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        $user->setting()->create();
    }
}
