<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\TimezonePromotionDateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCountryTrait;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\BelongsToShopTrait;
use App\Traits\Models\TimezoneDateTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\MorphToManyTags;
use App\Enums\InventoryConditionEnum;
use App\Enums\GeneralStatusEnum;

class Inventory extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        EnableScopeTrait,
        TimezoneDateTrait,
        BelongsToShopTrait,
        BelongsToCountryTrait,
        BelongsToCreatorTrait,
        TimezonePromotionDateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'quantity',
        'alert_quantity',
        'description',
        'delivery_price',
        'purchase_price',
        'sale_price',
        'promotion_price',
        'promotion_started_at',
        'promotion_ended_at',
        'condition',

        'shop_id',
        'creator_id',
        'vendor_id',
        'country_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
        'condition' => InventoryConditionEnum::class,
        'promotion_started_at' => 'datetime',
        'promotion_ended_at' => 'datetime',
    ];

    /**
     * Get the vendor that owns the current model.
     *
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
