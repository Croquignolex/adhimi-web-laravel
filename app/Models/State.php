<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCountryTrait;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\StatusBadgeTrait;
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
        StatusBadgeTrait,
        EnableScopeTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
        BelongsToCountryTrait,
        BelongsToCreatorTrait;

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
     * Scope a query to only include search model.
     */
    public function scopeSearch(Builder $query, string $q): void
    {
        $chainedBuilder = $query;
        $needles = explode(' ', $q);

        foreach ($needles as $key => $needle)
        {
            if($key === 0) {
                $chainedBuilder = $chainedBuilder->where('name', 'LIKE', "%$needle%");
            } else {
                $chainedBuilder = $chainedBuilder->orWhere('name', 'LIKE', "%$needle%");
            }
        }
    }
}
