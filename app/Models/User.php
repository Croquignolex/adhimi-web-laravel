<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\UserStatusBadgeTrait;
use App\Traits\Models\MorphOneAvatarTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\BelongsToShopTrait;
use App\Traits\Models\UserCreationsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
use Illuminate\Notifications\Notifiable;
use App\Traits\Models\SearchScopeTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Models\UniqueSlugTrait;
use App\Traits\Models\RouteSlugTrait;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserStatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasUuids,
        HasRoles,
        HasFactory,
        Notifiable,
        SoftDeletes,
        RouteSlugTrait,
        UniqueSlugTrait,
        SearchScopeTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        BelongsToShopTrait,
        UserCreationsTrait,
        MorphOneAvatarTrait,
        UserStatusBadgeTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        MorphOneDefaultAddressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'status',
        'description',
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
        'status' => UserStatusEnum::class,
    ];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['roles'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->remember_token = Str::random(60);
            $user->password = Hash::make($user->password ?? config('app.default_password'));
        });

        static::created(function (User $user) {
            $user->setting()->create();
        });
    }

    /**
     * Scope a query to only include model without super admin.
     */
    public function scopeAllow(Builder $query): void
    {
        $query
            ->where('id', '<>', $this->id)
            ->whereDoesntHave('roles', function (Builder $query) {
                $query->where('name', UserRoleEnum::SuperAdmin->value);
            });
    }

    /**
     * Scope a query to only include enable model.
     */
    public function scopeEnable(Builder $query): void
    {
        $query->where('status', UserStatusEnum::Active);
    }

    /**
     * Determine if user admin, magic attribute $this->is_admin.
     *
     * @return Attribute
     */
    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole([UserRoleEnum::SuperAdmin->value, UserRoleEnum::Admin->value])
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
     * Determine user entity, magic attribute $this->initials.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        $this->load('avatar');

        $url = (Auth::id() === $this->id)
            ? route('admin.profile.general')
            : route('admin.users.show', [$this]);

        return new Attribute(
            get: fn () => [
                'url' => $url,
                'image' => $this->avatar?->url,
                'label' => $this->name,
                'has_image' => true,
            ]
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
                    'value' => __('general.role.' . UserRoleEnum::SuperAdmin->value),
                    'color' => 'danger',
                ],
                UserRoleEnum::Admin->value => [
                    'value' => __('general.role.' . UserRoleEnum::Admin->value),
                    'color' => 'warning',
                ],
                UserRoleEnum::Merchant->value => [
                    'value' => __('general.role.' . UserRoleEnum::Merchant->value),
                    'color' => 'primary',
                ],
                UserRoleEnum::ShopManager->value => [
                    'value' => __('general.role.' . UserRoleEnum::ShopManager->value),
                    'color' => 'info',
                ],
                UserRoleEnum::Seller->value => [
                    'value' => __('general.role.' . UserRoleEnum::Seller->value),
                    'color' => 'secondary',
                ],
                default => [
                    'value' => __('general.status.unknown'),
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
}
