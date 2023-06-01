<?php

namespace App\Traits\Models;

use App\Models\InventoryHistory;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyInventoryHistoriesTrait
{
    /**
     * Get inventory histories associated with the current model.
     *
     * @return HasMany
     */
    public function inventoryHistories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }
}
