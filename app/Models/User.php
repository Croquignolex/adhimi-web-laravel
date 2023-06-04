<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\BelongsToShopTrait;
use App\Traits\Models\UserCreationsTrait;
use Illuminate\Notifications\Notifiable;
use App\Traits\Models\TimezoneDateTrait;
use App\Traits\Models\UniqueSlugTrait;
use Spatie\Permission\Traits\HasRoles;
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
        UniqueSlugTrait,
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
        'password',
        'profession',
        'gender',
        'birthdate',
        'status',
        'description',
        'first_purchase',
        'default_password',

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
        'default_password' => 'boolean',
        'status' => UserStatusEnum::class,
        'gender' => GenderEnum::class,
    ];

    /**
     * Manage first name, attribute $this->first_name.
     *
     * @return Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => mb_strtolower($value, 'UTF-8'),
        );
    }

    /**
     * Manage last name, attribute $this->last_name.
     *
     * @return Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => mb_strtoupper($value, 'UTF-8'),
            set: fn (string $value) => mb_strtolower($value, 'UTF-8'),
        );
    }

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
     * Determine user full name, magic attribute $this->full_name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => (is_null($this->last_name))
                ? $this->first_name
                : $this->first_name . " " . $this->first_name
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
                    return mb_substr($this->last_name, 0, 2);
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
     * Determine user role, magic attribute $this->role.
     *
     * @return Attribute
     */
    protected function role(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getRoleNames()->first()
        );
    }

    /**
     * Determine user roles badge, magic attribute $this->roles_badge.
     *
     * @return Attribute
     */
    protected function rolesBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->role) {
                UserRoleEnum::SuperAdmin->value => [
                    'value' => UserRoleEnum::SuperAdmin->value,
                    'color' => 'danger',
                ],
                UserRoleEnum::Admin->value => [
                    'value' => UserRoleEnum::Admin->value,
                    'color' => 'danger',
                ],
                UserRoleEnum::Merchant->value => [
                    'value' => UserRoleEnum::Merchant->value,
                    'color' => 'warning',
                ],
                UserRoleEnum::ShopManager->value => [
                    'value' => UserRoleEnum::ShopManager->value,
                    'color' => 'primary',
                ],
                UserRoleEnum::Saler->value => [
                    'value' => UserRoleEnum::Saler->value,
                    'color' => 'info',
                ],
                default => [
                    'value' => UserRoleEnum::Customer->value,
                    'color' => 'secondary',
                ]
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
                ],
                default => [
                    'value' => 'Unknown',
                    'color' => 'secondary',
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
            ->whereType(MediaTypeEnum::Avatar);
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
        return $this->hasMany(Log::class, 'creator_id');
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
