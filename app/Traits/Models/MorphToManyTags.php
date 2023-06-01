<?php

namespace App\Traits\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
