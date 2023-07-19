<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use App\Traits\Models\HasManySellersTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\MorphToManyTags;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;
use App\Enums\UserRoleEnum;

class Organisation extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        UniqueSlugTrait,
        SearchScopeTrait,
        EnableScopeTrait,
        HasManyUsersTrait,
        MorphOneLogoTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        HasManySellersTrait,
        MorphOneBannerTrait,
        HasManyProductsTrait,
        BelongsToCreatorTrait,
        GeneralStatusBadgeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'website',
        'phone',
        'status',
        'description',
        'seo_title',
        'seo_description',

        'creator_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['logo', 'merchant.avatar', 'creator.avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name', 'phone'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Determine if merchant can be added to organisation, magic attribute $this->can_add_merchant.
     *
     * @return Attribute
     */
    protected function canAddMerchant(): Attribute
    {
        return new Attribute(
            get: fn () => is_null($this->merchant)
        );
    }

    /**
     * Determine if merchant can be added to organisation, magic attribute $this->can_add_manager.
     *
     * @return Attribute
     */
    protected function canAddManager(): Attribute
    {
        return new Attribute(
            get: fn () => $this->shops()->whereDoesntHave('manager')->count() > 0
        );
    }

    /**
     * Determine organisation entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: fn () => [
                'url' => route('admin.organisations.show', [$this]),
                'image' => $this->logo?->url,
                'label' => $this->name,
                'has_image' => true,
            ]
        );
    }

    /**
     * Get merchant associated with the organisation.
     *
     * @return HasOne
     */
    public function merchant(): HasOne
    {
        return $this->hasOne(User::class)->whereHas('roles', function (Builder $query) {
            $query->where('name', UserRoleEnum::Merchant->value);
        });
    }

    /**
     * Get managers associated with the organisation.
     *
     * @return HasMany
     */
    public function managers(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function (Builder $query) {
            $query->where('name', UserRoleEnum::ShopManager->value);
        });
    }

    /**
     * Get shops associated with the organisation.
     *
     * @return HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * Get vendors associated with the organisation.
     *
     * @return HasMany
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }
}
