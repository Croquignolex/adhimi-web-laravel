<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Country;

trait BelongsToCountryTrait
{
    /**
     * Get the country that owns the current model.
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
