<?php

namespace App\Models;

use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\BelongsToOrganisationTrait;
use App\Traits\Models\BelongsToShopTrait;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryHistory extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        TimezoneDateTrait,
        BelongsToShopTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        HasManyInventoryHistoriesTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'old_quantity',
        'description',

        'stockable_type',
        'stockable_id',

        'shop_id',
        'creator_id',
        'product_id',
        'organisation_id'
    ];

    /**
     * Get the parent stockable models.
     *
     * @return MorphTo
     */
    public function stockable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the product that owns the current model.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
