<?php

namespace App\Traits\Models;

use App\Enums\AddressTypeEnum;
use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneDefaultAddressTrait
{
    /**
     * Get model default address.
     *
     * @return MorphOne
     */
    public function defaultAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')
            ->whereType(AddressTypeEnum::Default);
    }
}
