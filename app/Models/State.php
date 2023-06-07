<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCountryTrait;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneFlagTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GeneralStatusEnum;

class State extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        EnableScopeTrait,
        MorphOneFlagTrait,
        BelongsToCountryTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'status',

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
}
