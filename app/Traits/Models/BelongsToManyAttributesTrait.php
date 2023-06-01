<?php

namespace App\Traits\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyAttributesTrait
{
    /**
     * The attributes that belong to the current mode.
     *
     * @return BelongsToMany
     */
    public function attributedAttributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }
}
