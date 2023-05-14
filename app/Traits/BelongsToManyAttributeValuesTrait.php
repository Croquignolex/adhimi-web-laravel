<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\AttributeValue;

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
