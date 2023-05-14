<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Attribute;

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
