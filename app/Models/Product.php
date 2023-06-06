<?php

namespace App\Models;

use App\Traits\Models\BelongsToManyAttributeValuesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Traits\Models\BelongsToManyAttributesTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\Models\BelongsToOrganisationTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\TimezoneDateTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\MorphToManyTags;
use App\Enums\DistanceValueEnum;
use App\Enums\GeneralStatusEnum;
use App\Enums\QuantityValueEnum;
use App\Enums\WeightValueEnum;
use App\Enums\MediaTypeEnum;

class Product extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        EnableScopeTrait,
        TimezoneDateTrait,
        BelongsToCreatorTrait,
        BelongsToOrganisationTrait,
        BelongsToManyAttributesTrait,
        BelongsToManyAttributeValuesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'status',
        'description',
        'min_price',
        'max_price',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'volume_unit',
        'seo_title',
        'seo_description',

        'creator_id',
        'category_id',
        'brand_id',
        'organisation_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => GeneralStatusEnum::class,
        'weight_unit' => WeightValueEnum::class,
        'height_unit' => DistanceValueEnum::class,
        'width_unit' => DistanceValueEnum::class,
        'depth_unit' => DistanceValueEnum::class,
        'volume_unit' => QuantityValueEnum::class,
    ];

    /**
     * Determine note, magic attribute $this->note.
     *
     * @return Attribute
     */
    protected function note(): Attribute
    {
        return new Attribute(
            get: fn () => $this->rates()->avg('note')
        );
    }

    /**
     * Get product ratings.
     *
     * @return MorphMany
     */
    public function rates(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratable');
    }

    /**
     * Get product gallery images.
     *
     * @return MorphMany
     */
    public function galleryImages(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Image);
    }

    /**
     * Get product presentation video.
     *
     * @return MorphOne
     */
    public function presentationVideo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Video);
    }

    /**
     * Get product about notice.
     *
     * @return MorphOne
     */
    public function aboutNotice(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')
            ->whereType(MediaTypeEnum::Document);
    }

    /**
     * Get the category that owns the current model.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the current model.
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
