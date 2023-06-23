<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\BelongsToOrganisationTrait;
use App\Traits\Models\TimezonePromotionDateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Traits\Models\RouteSlugTrait;
use App\Enums\GeneralStatusEnum;

class Coupon extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        RouteSlugTrait,
        UniqueSlugTrait,
        SearchScopeTrait,
        EnableScopeTrait,
        StatusBadgeTrait,
        MorphManyLogsTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        TimezonePromotionDateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'slug',
        'status',
        'discount',
        'total_use',
        'description',
        'promotion_started_at',
        'promotion_ended_at',

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
        'promotion_started_at' => 'datetime',
        'promotion_ended_at' => 'datetime',
    ];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['code', 'discount'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Coupon $coupon) {
            $coupon->slug = $coupon->code;
        });

        static::updating(function (Coupon $coupon) {
            $coupon->slug = $coupon->code;
        });
    }
}
