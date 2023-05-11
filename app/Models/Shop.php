<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\HasManyUsersTrait;
use App\Traits\MorphOneLogoTrait;
use App\Enums\GeneralStatusEnum;
use App\Traits\MorphToManyTags;

class Shop extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        MorphOneLogoTrait,
        HasManyUsersTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait;

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
