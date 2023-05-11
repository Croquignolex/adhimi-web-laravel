<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Enums\MediaTypeEnum;
use App\Models\Media;

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
