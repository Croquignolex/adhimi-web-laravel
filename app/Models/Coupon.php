<?php

namespace App\Models;

use App\Enums\GeneralStatusEnum;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\BelongsToOrganisationTrait;
use App\Traits\Models\TimezoneDateTrait;
use App\Traits\Models\TimezonePromotionDateTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        TimezoneDateTrait,
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
}
