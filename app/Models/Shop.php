<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\BelongsToOrganisationTrait;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManySellersTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;
use App\Enums\UserRoleEnum;

class Shop extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        EnableScopeTrait,
        SearchScopeTrait,
        HasManyUsersTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        HasManySellersTrait,
        BelongsToCreatorTrait,
        GeneralStatusBadgeTrait,
        BelongsToOrganisationTrait,
        MorphOneDefaultAddressTrait,
        HasManyInventoryHistoriesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',

        'creator_id',
        'organisation_id',
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
    protected $with = ['organisation.logo', 'manager.avatar', 'creator.avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllowed(Builder $query): void
    {

    }

    /**
     * Scope a query to only include free model.
     */
    public function scopeFree(Builder $query, string $q): void
    {
        if($q === 'free') {
            $query->whereDoesntHave('manager');
        }
    }

    /**
     * Determine if manager can be added to shop, magic attribute $this->can_add_manager.
     *
     * @return Attribute
     */
    protected function canAddManager(): Attribute
    {
        return new Attribute(
            get: fn () => is_null($this->manager)
        );
    }

    /**
     * Determine shop entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: fn () => [
                'url' => route('admin.shops.show', [$this]),
                'label' => $this->name,
                'has_image' => false,
            ]
        );
    }

    /**
     * Get manager associated with the organisation.
     *
     * @return HasOne
     */
    public function manager(): HasOne
    {
        return $this->hasOne(User::class)->whereHas('roles', function (Builder $query) {
            $query->where('name', UserRoleEnum::ShopManager->value);
        });
    }
}
