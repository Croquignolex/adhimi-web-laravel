<?php

namespace App\Traits\Models;

use App\Enums\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneHardCopyTrait
{
    /**
     * Get model's hard copy.
     *
     * @return MorphOne
     */
    public function hardCopy(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Image);
    }
}
