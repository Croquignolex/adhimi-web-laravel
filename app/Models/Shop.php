<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\MorphToManyTags;
use App\Enums\GeneralStatusEnum;

class Shop extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        MorphOneLogoTrait,
        HasManyUsersTrait,
        TimezoneDateTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        MorphOneDefaultAddressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'email',
        'address',
        'phone',
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
