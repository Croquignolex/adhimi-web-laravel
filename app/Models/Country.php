<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\NameInitialsTrait;
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
        StatusBadgeTrait,
        EnableScopeTrait,
        NameInitialsTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
        HasManyProductsTrait,
        BelongsToCreatorTrait;

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
     * Scope a query to only include search model.
     */
    public function scopeSearch(Builder $query, string $q): void
    {
        $chainedBuilder = $query;
        $needles = explode(' ', $q);

        foreach ($needles as $key => $needle)
        {
            if($key === 0) {
                $chainedBuilder = $chainedBuilder->where('name', 'LIKE', "%$needle%")
                    ->orWhere('phone_code', 'LIKE', "%$needle%");
            } else {
                $chainedBuilder = $chainedBuilder->orWhere('name', 'LIKE', "%$needle%")
                    ->orWhere('phone_code', 'LIKE', "%$needle%");
            }
        }
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
