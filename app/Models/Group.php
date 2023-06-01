<?php

namespace App\Models;

use App\Enums\GeneralStatusEnum;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\MorphToManyTags;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        TimezoneDateTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'slug',
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
