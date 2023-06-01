<?php

namespace App\Traits\Models;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyAttributeValuesTrait
{
    /**
     * The attributes value that belong to the current mode.
     *
     * @return BelongsToMany
     */
    public function attributedAttributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute');
    }
}
