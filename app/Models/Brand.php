<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\HasManyProductsTrait;
use App\Traits\Models\MorphOneLogoTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\EnableScopeTrait;
use App\Enums\GeneralStatusEnum;

class Brand extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        EnableScopeTrait,
        MorphOneLogoTrait,
        HasManyProductsTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'description',
        'seo_title',
        'seo_description',

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
}
