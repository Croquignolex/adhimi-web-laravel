<?php

namespace App\Models;

use App\Traits\Models\BelongsToManyAttributeValuesTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\UniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Models\BelongsToManyProductsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\EnableScopeTrait;
use App\Enums\AttributeTypeEnum;
use App\Enums\GeneralStatusEnum;

class Attribute extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        UniqueSlugTrait,
        EnableScopeTrait,
        SlugFromNameTrait,
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
        'slug',
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
