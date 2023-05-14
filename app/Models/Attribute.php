<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToManyAttributeValuesTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToManyProductsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\GeneralStatusEnum;
use App\Enums\AttributeTypeEnum;

class Attribute extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        TimezoneDateTrait,
        BelongsToCreatorTrait,
        BelongsToManyProductsTrait,
        BelongsToManyAttributeValuesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
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
        'type' => AttributeTypeEnum::class,
    ];

    /**
     * Get attribute values associated with the attribute.
     *
     * @return HasMany
     */
    public function attributesValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
