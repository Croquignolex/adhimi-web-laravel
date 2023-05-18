<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MorphOneDefaultAddressTrait;
use App\Traits\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\HasManyProductsTrait;
use App\Traits\TimezoneDateTrait;
use App\Traits\MorphOneLogoTrait;
use App\Enums\GeneralStatusEnum;

class Vendor extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphOneLogoTrait,
        TimezoneDateTrait,
        HasManyProductsTrait,
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
        'phone',
        'address',
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
