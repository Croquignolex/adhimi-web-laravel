<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MorphOneDefaultAddressTrait;
use App\Traits\BelongsToOrganisationTrait;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\UserCreationsTrait;
use App\Traits\BelongsToShopTrait;
use App\Traits\MorphManyLogsTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\AddressTypeEnum;
use App\Enums\UserStatusEnum;
use App\Enums\MediaTypeEnum;
use App\Enums\UserRoleEnum;
use App\Enums\GenderEnum;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasUuids,
        HasRoles,
        HasFactory,
        Notifiable,
        SoftDeletes,
        TimezoneDateTrait,
        MorphManyLogsTrait,
        BelongsToShopTrait,
        UserCreationsTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        MorphOneDefaultAddressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'email',
        'avatar',
        'password',
        'profession',
        'gender',
        'birthdate',
        'status',
        'description',
        'first_purchase',

        'shop_id',
        'creator_id',
        'organisation_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date',
        'first_purchase' => 'boolean',
        'status' => UserStatusEnum::class,
        'gender' => GenderEnum::class,
    ];

    /**
     * Determine timezone birthdate, magic attribute $this->tz_birthdate.
     *
     * @return Attribute
     */
    protected function TzBirthdate(): Attribute
    {
        $field = $this->birthdate;
        return new Attribute(
            get: fn () => is_null($field) ? $field : $this->timezoneDate($field)
        );
    }

    /**
     * Determine if user is super admin, magic attribute $this->is_super_admin.
     *
     * @return Attribute
     */
    protected function isSuperAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::SuperAdmin->value])
        );
    }

    /**
     * Determine if user admin, magic attribute $this->is_admin.
     *
     * @return Attribute
     */
    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::Admin->value])
        );
    }

    /**
     * Determine if user is merchant, magic attribute $this->is_merchant.
     *
     * @return Attribute
     */
    protected function isMerchant(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::Merchant->value])
        );
    }

    /**
     * Determine if user is shop manager, magic attribute $this->is_shop_manager.
     *
     * @return Attribute
     */
    protected function isShopManager(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::ShopManager->value])
        );
    }

    /**
     * Determine if user is saler, magic attribute $this->is_saler.
     *
     * @return Attribute
     */
    protected function isSaler(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::Saler->value])
        );
    }

    /**
     * Determine if user is customer, magic attribute $this->is_customer.
     *
     * @return Attribute
     */
    protected function isCustomer(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasExactRoles([UserRoleEnum::Customer->value])
        );
    }

    /**
     * Determine user full name, magic attribute $this->full_name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        $formatFirstName = ucfirst($this->first_name);

        return new Attribute(
            get: fn () => (is_null($this->last_name))
                ? $formatFirstName
                : $formatFirstName . " " . strtoupper($this->first_name)
        );
    }


    /**
     * Determine user initials, magic attribute $this->initials.
     *
     * @return Attribute
     */
    protected function initials(): Attribute
    {
        return new Attribute(
            get: function () {
                if(is_null($this->first_name)) {
                    return mb_substr(strtoupper($this->last_name), 0, 2);
                }

                $nameArray = explode(' ', $this->full_name);
                if(count($nameArray) > 1) {
                    return mb_substr($nameArray[0], 0, 1) . mb_substr($nameArray[1], 0, 1);
                }
                return mb_substr($nameArray[0], 0, 2);
            }
        );
    }

    /**
     * Determine user status badge, magic attribute $this->status_badge.
     *
     * @return Attribute
     */
    protected function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->status) {
                UserStatusEnum::Active => [
                    'value' => UserStatusEnum::Active->value,
                    'color' => 'success',
                ],
                UserStatusEnum::Blocked => [
                    'value' => UserStatusEnum::Blocked->value,
                    'color' => 'danger',
                ]
            }
        );
    }

    /**
     * Get setting associated with the user.
     *
     * @return HasOne
     */
    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    /**
     * Get user avatar.
     *
     * @return MorphOne
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Image);
    }

    /**
     * Get user billing address.
     *
     * @return MorphOne
     */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Media::class, 'addressable')
            ->whereType(AddressTypeEnum::Billing);
    }

    /**
     * Get user shipping address.
     *
     * @return MorphOne
     */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Media::class, 'addressable')
            ->whereType(AddressTypeEnum::Shipping);
    }

    /**
     * Get logs associated with the user.
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get ratings associated with the user.
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get invoices associated with the user.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
