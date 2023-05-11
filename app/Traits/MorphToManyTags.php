<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Tag;

trait MorphToManyTags
{
    /**
     * Get all the tags for the current model.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
