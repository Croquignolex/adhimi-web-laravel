<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\MorphOneFlagTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GeneralStatusEnum;

class Country extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        StatusBadgeTrait,
        EnableScopeTrait,
        MorphOneFlagTrait,
        NameInitialsTrait,
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
        'latitude',
        'longitude',
        'status',

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
        $query->where('name', 'LIKE', "%$q%")
            ->orWhere('phone_code', 'LIKE', "%$q%");
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
}
