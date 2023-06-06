<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Models\HasManyInventoryHistoriesTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\BelongsToShopTrait;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        TimezoneDateTrait,
        BelongsToShopTrait,
        BelongsToCreatorTrait,
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

        'shop_id',
        'creator_id',
        'product_id',
    ];

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
