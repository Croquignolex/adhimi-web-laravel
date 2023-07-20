<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InventoryHistory;
use App\Models\AttributeValue;
use App\Models\Organisation;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Address;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\Coupon;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Media;
use App\Models\State;
use App\Models\Shop;
use App\Models\User;
use App\Models\Log;

trait UserCreationsTrait
{
    /**
     * Get created logs associated with the user.
     *
     * @return HasMany
     */
    public function createdLogs(): HasMany
    {
        return $this->hasMany(Log::class, 'creator_id');
    }

    /**
     * Get created organisations associated with the user.
     *
     * @return HasMany
     */
    public function createdOrganisations(): HasMany
    {
        return $this->hasMany(Organisation::class, 'creator_id');
    }

    /**
     * Get created shops associated with the user.
     *
     * @return HasMany
     */
    public function createdShops(): HasMany
    {
        return $this->hasMany(Shop::class, 'creator_id');
    }

    /**
     * Get created vendors associated with the user.
     *
     * @return HasMany
     */
    public function createdVendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'creator_id');
    }

    /**
     * Get created attributes associated with the user.
     *
     * @return HasMany
     */
    public function createdAttributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'creator_id');
    }

    /**
     * Get created attribute values associated with the user.
     *
     * @return HasMany
     */
    public function createdAttributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'creator_id');
    }

    /**
     * Get created users associated with the user.
     *
     * @return HasMany
     */
    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'creator_id');
    }

    /**
     * Get created brands associated with the user.
     *
     * @return HasMany
     */
    public function createdBrands(): HasMany
    {
        return $this->hasMany(Brand::class, 'creator_id');
    }

    /**
     * Get created countries associated with the user.
     *
     * @return HasMany
     */
    public function createdCountries(): HasMany
    {
        return $this->hasMany(Country::class, 'creator_id');
    }

    /**
     * Get created states associated with the user.
     *
     * @return HasMany
     */
    public function createdStates(): HasMany
    {
        return $this->hasMany(State::class, 'creator_id');
    }

    /**
     * Get created medias associated with the user.
     *
     * @return HasMany
     */
    public function createdMedias(): HasMany
    {
        return $this->hasMany(Media::class, 'creator_id');
    }

    /**
     * Get created addresses associated with the user.
     *
     * @return HasMany
     */
    public function createdAddresses(): HasMany
    {
        return $this->hasMany(Address::class, 'creator_id');
    }

    /**
     * Get created groups associated with the user.
     *
     * @return HasMany
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'creator_id');
    }

    /**
     * Get created categories associated with the user.
     *
     * @return HasMany
     */
    public function createdCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'creator_id');
    }

    /**
     * Get created inventory histories associated with the user.
     *
     * @return HasMany
     */
    public function createdInventoryHistories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class, 'creator_id');
    }

    /**
     * Get created coupons associated with the user.
     *
     * @return HasMany
     */
    public function createdCoupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'creator_id');
    }
}
