<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCountryTrait;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;

class State extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        SearchScopeTrait,
        EnableScopeTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
        BelongsToCountryTrait,
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
        'latitude',
        'longitude',
        'status',
        'description',

        'country_id',
        'creator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
        'latitude' => 'float',
        'longitude' => 'float',
    ];

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
     * Determine country entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: fn () => [
                'url' => route('admin.states.show', [$this]),
                'label' => $this->name,
                'has_image' => false,
            ]
        );
    }
}
