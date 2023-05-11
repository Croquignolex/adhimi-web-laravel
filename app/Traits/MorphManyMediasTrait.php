<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Media;

trait MorphManyMediasTrait
{
    /**
     * Get all the morph model's medias.
     *
     * @return MorphMany
     */
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediatable');
    }
}
