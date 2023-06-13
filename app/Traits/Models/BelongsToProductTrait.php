<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

trait BelongsToProductTrait
{
    /**
     * Get the product that owns the current model.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
