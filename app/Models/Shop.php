<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\MorphToManyTags;
use App\Enums\GeneralStatusEnum;

class Shop extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        EnableScopeTrait,
        MorphOneLogoTrait,
        HasManyUsersTrait,
        MorphOneBannerTrait,
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
}
