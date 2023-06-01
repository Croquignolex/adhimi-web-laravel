<?php

namespace App\Traits\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToShopTrait
{
    /**
     * Get the shop that owns the current model.
     *
     * @return BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
