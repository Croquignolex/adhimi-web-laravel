<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\BelongsToManyAttributesTrait;
use App\Traits\Models\BelongsToManyProductsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GeneralStatusEnum;

class AttributeValue extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        EnableScopeTrait,
        BelongsToCreatorTrait,
        BelongsToManyProductsTrait,
        BelongsToManyAttributesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
        'status',
        'description',

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

    /**
     * Get the attribute that owns the current model.
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
