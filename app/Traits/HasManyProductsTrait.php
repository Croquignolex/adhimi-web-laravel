<?php

namespace App\Traits;

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
