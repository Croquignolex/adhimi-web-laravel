<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToOrganisationTrait;
use App\Traits\TimezonePromotionDateTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\BelongsToCountryTrait;
use App\Traits\BelongsToShopTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\GeneralStatusEnum;
use App\Traits\MorphToManyTags;
use App\Enums\MediaTypeEnum;

class Product extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        TimezoneDateTrait,
        BelongsToShopTrait,
        BelongsToCountryTrait,
        BelongsToCreatorTrait,
        TimezonePromotionDateTrait,
        BelongsToOrganisationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'quantity',
        'alert_quantity',
        'description',
        'delivery_price',
        'purchase_price',
        'sale_price',
        'weight',
        'promotion_price',
        'promotion_started_at',
        'promotion_ended_at',

        'creator_id',
        'vendor_id',
        'category_id',
        'brand_id',
        'organisation_id',
        'country_id',
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
        'weight' => 'float',
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
            ->whereType(MediaTypeEnum::Txt)
            ->orWereType(MediaTypeEnum::PDF);
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
     * Get the vendor that owns the current model.
     *
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
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
