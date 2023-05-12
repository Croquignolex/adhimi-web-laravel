<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\MorphOneBannerTrait;
use App\Traits\TimezoneDateTrait;
use App\Traits\HasManyUsersTrait;
use App\Traits\MorphOneLogoTrait;
use App\Enums\GeneralStatusEnum;
use App\Traits\MorphToManyTags;

class Organisation extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        HasManyUsersTrait,
        TimezoneDateTrait,
        MorphOneLogoTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait;

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
        'website',
        'description',

        'creator_id'
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
     * Get shops associated with the organisations.
     *
     * @return HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * Get vendors associated with the organisations.
     *
     * @return HasMany
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }
}
