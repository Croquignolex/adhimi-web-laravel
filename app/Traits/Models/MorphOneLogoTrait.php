<?php

namespace App\Traits\Models;

use App\Enums\MediaTypeEnum;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
