<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InventoryHistory;
use App\Models\Organisation;
use App\Models\Attribute;
use App\Models\Address;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\Group;
use App\Models\Media;
use App\Models\State;
use App\Models\Shop;
use App\Models\User;
use App\Models\Log;

trait UserCreationsTrait
{
    /**
     * Get created organisations associated with the user.
     *
     * @return HasMany
     */
    public function createdOrganisations(): HasMany
    {
        return $this->hasMany(Organisation::class);
    }

    /**
     * Get created shops associated with the user.
     *
     * @return HasMany
     */
    public function createdShops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * Get created vendors associated with the user.
     *
     * @return HasMany
     */
    public function createdVendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * Get created attributes associated with the user.
     *
     * @return HasMany
     */
    public function createdAttributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * Get created users associated with the user.
     *
     * @return HasMany
     */
    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get created logs associated with the user.
     *
     * @return HasMany
     */
    public function createdLogs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get created countries associated with the user.
     *
     * @return HasMany
     */
    public function createdLCountries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    /**
     * Get created states associated with the user.
     *
     * @return HasMany
     */
    public function createdLStates(): HasMany
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get created medias associated with the user.
     *
     * @return HasMany
     */
    public function createdMedias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get created addresses associated with the user.
     *
     * @return HasMany
     */
    public function createdAddresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get created groups associated with the user.
     *
     * @return HasMany
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Get created inventory histories associated with the user.
     *
     * @return HasMany
     */
    public function createdInventoryHistories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }
}
