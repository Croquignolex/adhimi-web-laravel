<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Enums\GeneralStatusEnum;
use App\Enums\MediaTypeEnum;

class Country extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        SearchScopeTrait,
        StatusBadgeTrait,
        EnableScopeTrait,
        NameInitialsTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
        BelongsToCreatorTrait,
        HasManyInventoryHistoriesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_code',
        'name',
        'slug',
        'latitude',
        'longitude',
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
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name', 'phone_code'];

    /**
     * Determine country entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        $this->load('flag');

        return new Attribute(
            get: fn () => [
                'url' => route('admin.countries.show', [$this]),
                'image' => $this->flag?->url,
                'label' => $this->name,
                'has_image' => true,
            ]
        );
    }

    /**
     * Get the states for the country.
     *
     * @return HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get country's flag.
     *
     * @return MorphOne
     */
    public function flag(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Flag);
    }
}
