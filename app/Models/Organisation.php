<?php

namespace App\Models;

use App\Enums\GeneralStatusEnum;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\MorphOneDefaultAddressTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\MorphToManyTags;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        EnableScopeTrait,
        HasManyUsersTrait,
        TimezoneDateTrait,
        MorphOneLogoTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait,
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
