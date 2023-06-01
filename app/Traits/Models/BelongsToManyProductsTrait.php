<?php

namespace App\Traits\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyProductsTrait
{
    /**
     * The products that belong to the current mode.
     *
     * @return BelongsToMany
     */
    public function attributedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute');
    }
}
