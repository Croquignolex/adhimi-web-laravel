<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Organisation;

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
