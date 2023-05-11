<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shop;

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
