<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\GeneralStatusEnum;

trait EnableScopeTrait
{
    /**
     * Scope a query to only include enable model.
     */
    public function scopeEnable(Builder $query): void
    {
        $query->where('status', GeneralStatusEnum::Enable);
    }
}
