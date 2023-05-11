<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Enums\MediaTypeEnum;
use App\Models\Media;

trait MorphOneHardCopyTrait
{
    /**
     * Get model's hard copy.
     *
     * @return MorphOne
     */
    public function hardCopy(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')->whereType(MediaTypeEnum::Image);
    }
}
