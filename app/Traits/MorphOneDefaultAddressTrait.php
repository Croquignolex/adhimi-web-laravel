<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Enums\AddressTypeEnum;
use App\Models\Address;

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
