<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManySellersTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
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
        StatusBadgeTrait,
        HasManyUsersTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        HasManySellersTrait,
        BelongsToCreatorTrait,
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
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

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
