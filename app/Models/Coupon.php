<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TimezonePromotionDateTrait;
use App\Traits\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\GeneralStatusEnum;

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
