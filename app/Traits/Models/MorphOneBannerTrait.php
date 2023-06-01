<?php

namespace App\Traits\Models;

use App\Enums\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneBannerTrait
{
    /**
     * Get model's banner.
     *
     * @return MorphOne
     */
    public function banner(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Banner);
    }
}
