<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

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
