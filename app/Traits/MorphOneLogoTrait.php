<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Enums\MediaTypeEnum;
use App\Models\Media;

trait MorphOneLogoTrait
{
    /**
     * Get model's logo.
     *
     * @return MorphOne
     */
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Logo);
    }
}
