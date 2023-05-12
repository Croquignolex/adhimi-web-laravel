<?php

namespace App\Models;

use App\Traits\HasManyProductsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\TimezoneDateTrait;
use App\Traits\MorphOneFlagTrait;
use App\Enums\GeneralStatusEnum;

class Country extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphOneFlagTrait,
        TimezoneDateTrait,
        HasManyProductsTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_extension',
        'code',
        'name',
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
    ];

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
