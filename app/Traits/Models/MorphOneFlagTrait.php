<?php

namespace App\Traits\Models;

use App\Enums\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneFlagTrait
{
    /**
     * Get model's flag.
     *
     * @return MorphOne
     */
    public function flag(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Image);
    }
}
