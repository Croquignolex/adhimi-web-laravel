<?php

namespace App\Traits\Models;

use App\Models\Log;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MorphManyLogsTrait
{
    /**
     * Get all the morph model's logs.
     *
     * @return MorphMany
     */
    public function loggers(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
