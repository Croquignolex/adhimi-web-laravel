<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneBannerTrait;
use App\Traits\Models\MorphManyLogsTrait;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\SlugFromNameTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Traits\Models\StatusBadgeTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Traits\Models\MorphToManyTags;
use App\Enums\GeneralStatusEnum;

class Group extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        MorphToManyTags,
        UniqueSlugTrait,
        SearchScopeTrait,
        StatusBadgeTrait,
        EnableScopeTrait,
        NameInitialsTrait,
        SlugFromNameTrait,
        MorphManyLogsTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'slug',
        'description',
        'seo_title',
        'seo_description',

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
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['name'];

    /**
     * Get categories associated with the group.
     *
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get products associated with the group.
     */
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Category::class);
    }
}
