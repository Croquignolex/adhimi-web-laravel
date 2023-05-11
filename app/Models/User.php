<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\MorphManyLogsTrait;
use App\Traits\TimezoneDateTrait;
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
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'avatar',
        'password',
        'profession',
        'gender',
        'birthdate',
        'status',
        'description',
        'first_purchase',

        'creator_id',
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
        return new Attribute(
            get: fn () => is_null($this->birthdate)
                ? $this->birthdate
                : $this->timezoneDate($this->birthdate)
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
     * Determine user initials, magic attribute $this->initials.
     *
     * @return Attribute
     */
    protected function initials(): Attribute
    {
        return new Attribute(
            get: function () {
                $name = strtoupper($this->name);
                $nameArray = explode(' ', $name);
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
        return $this->morphOne(Media::class, 'mediatable')->whereType(MediaTypeEnum::Image);
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
     * Get created groups associated with the user.
     *
     * @return HasMany
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class);
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
     * Get invoices associated with the user.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
