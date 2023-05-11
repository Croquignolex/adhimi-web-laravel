<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Enums\GeneralStatusEnum;
use App\Traits\MorphToManyTags;
use App\Enums\MediaTypeEnum;

class Product extends Model
{
    use HasFactory, SoftDeletes, BelongsToCreatorTrait, HasUuids, MorphToManyTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'description',

        'creator_id',
        'group_id',
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
     * Get product gallery images.
     *
     * @return MorphMany
     */
    public function galleryImages(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediatable')->whereType(MediaTypeEnum::Image);
    }

    /**
     * Get product presentation video.
     *
     * @return MorphOne
     */
    public function presentationVideo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediatable')->whereType(MediaTypeEnum::Video);
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
}
