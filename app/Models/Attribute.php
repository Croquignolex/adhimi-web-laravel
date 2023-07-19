<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;
use App\Traits\Models\BelongsToManyAttributeValuesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Models\BelongsToManyProductsTrait;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\SearchScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\AttributeTypeEnum;
use App\Enums\GeneralStatusEnum;

class Attribute extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        EnableScopeTrait,
        SearchScopeTrait,
        SlugFromNameTrait,
        NameInitialsTrait,
        MorphManyLogsTrait,
        BelongsToCreatorTrait,
        GeneralStatusBadgeTrait,
        BelongsToManyProductsTrait,
        BelongsToManyAttributeValuesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'status',
        'description',

        'creator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
        'type' => AttributeTypeEnum::class,
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['creator.avatar'];

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
     * Determine attribute entity, magic attribute $this->entity.
     *
     * @return CastAttribute
     */
    protected function entity(): CastAttribute
    {
        return new CastAttribute(
            get: fn () => [
                'url' => route('admin.attributes.show', [$this]),
                'label' => $this->name,
                'has_image' => false,
            ]
        );
    }

    /**
     * Get attribute values associated with the attribute.
     *
     * @return HasMany
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
