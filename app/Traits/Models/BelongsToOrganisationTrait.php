<?php

namespace App\Traits\Models;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrganisationTrait
{
    /**
     * Get the organisation that owns the current model.
     *
     * @return BelongsTo
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
