<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Enums\MediaTypeEnum;
use App\Models\Media;

trait MorphOneAvatarTrait
{
    /**
     * Get model's avatar.
     *
     * @return MorphOne
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Avatar);
    }
}
