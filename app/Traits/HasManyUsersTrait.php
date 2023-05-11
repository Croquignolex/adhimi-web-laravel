<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

trait HasManyUsersTrait
{
    /**
     * Get users associated with the current model.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
