<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\SearchScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;

class Brand extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        SearchScopeTrait,
        EnableScopeTrait,
        MorphOneLogoTrait,
        NameInitialsTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
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
        'status',
        'website',
        'description',
        'seo_title',
        'seo_description',

        'creator_id',
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
    protected $with = ['logo', 'creator.avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

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
                'url' => route('admin.brands.show', [$this]),
                'image' => $this->logo?->url,
                'label' => $this->name,
                'has_image' => true,
            ]
        );
    }
}
