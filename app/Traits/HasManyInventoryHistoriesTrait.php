<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InventoryHistory;

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
