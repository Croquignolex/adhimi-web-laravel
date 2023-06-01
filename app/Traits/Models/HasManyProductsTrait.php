<?php

namespace App\Traits\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyProductsTrait
{
    /**
     * Get products associated with the current model.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
