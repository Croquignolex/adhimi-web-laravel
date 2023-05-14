<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;

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
