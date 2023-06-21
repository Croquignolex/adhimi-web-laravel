<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\UserRoleEnum;
use App\Models\User;

trait HasManySellersTrait
{
    /**
     * Get managers associated with the model.
     *
     * @return HasMany
     */
    public function sellers(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function (Builder $query) {
            $query->where('name', UserRoleEnum::Seller->value);
        });
    }
}
