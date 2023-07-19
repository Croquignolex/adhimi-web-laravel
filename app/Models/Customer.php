<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\UserStatusBadgeTrait;
use App\Traits\Models\MorphOneAvatarTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\UniqueSlugTrait;
use App\Traits\Models\RouteSlugTrait;
use Illuminate\Support\Facades\Hash;
use App\Enums\AddressTypeEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Str;
use App\Enums\GenderEnum;

class Customer extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasUuids,
        HasFactory,
        Notifiable,
        SoftDeletes,
        RouteSlugTrait,
        UniqueSlugTrait,
        SearchScopeTrait,
        MorphManyLogsTrait,
        MorphOneAvatarTrait,
        UserStatusBadgeTrait,
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
        'phone',
        'gender',
        'birthdate',
        'status',
        'description',
        'first_purchase',
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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['first_name', 'email', 'phone'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            $customer->slug = $customer->first_name;
            $customer->remember_token = Str::random(60);
            $customer->password = Hash::make($customer->password);
        });

        static::updating(function (Customer $customer) {
            $customer->slug = $customer->first_name;
        });
    }

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllowed(Builder $query): void
    {

    }

    /**
     * Scope a query to only include enable model.
     */
    public function scopeEnable(Builder $query): void
    {
        $query->where('status', UserStatusEnum::Active);
    }

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
            set: fn (string|null $value) => mb_strtolower($value, 'UTF-8'),
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
                : $this->first_name . " " . $this->last_name
        );
    }

    /**
     * Determine user entity, magic attribute $this->initials.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: fn () => [
                'url' => route('admin.customers.show', [$this]),
                'image' => $this->avatar?->url,
                'label' => $this->first_name,
                'has_image' => true,
            ]
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
                $nameArray = explode(' ', $this->full_name);
                if(count($nameArray) > 1) {
                    return mb_substr($nameArray[0], 0, 1) . mb_substr($nameArray[1], 0, 1);
                }
                return mb_substr($nameArray[0], 0, 2);
            }
        );
    }

    /**
     * Get user billing address.
     *
     * @return MorphOne
     */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')
            ->whereType(AddressTypeEnum::Billing);
    }

    /**
     * Get user shipping address.
     *
     * @return MorphOne
     */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')
            ->whereType(AddressTypeEnum::Shipping);
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
}
