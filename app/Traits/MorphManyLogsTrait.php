<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Log;

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
