<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Models\GeneralStatusBadgeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphManyLogsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\SearchScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UniqueSlugTrait;
use App\Traits\Models\RouteSlugTrait;
use App\Enums\GeneralStatusEnum;

class Coupon extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        RouteSlugTrait,
        UniqueSlugTrait,
        SearchScopeTrait,
        EnableScopeTrait,
        MorphManyLogsTrait,
        BelongsToCreatorTrait,
        GeneralStatusBadgeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'slug',
        'status',
        'discount',
        'total_use',
        'description',
        'promotion_started_at',
        'promotion_ended_at',

        'creator_id',
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
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['creator.avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['code', 'discount'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Coupon $coupon) {
            $coupon->slug = $coupon->code;
        });

        static::updating(function (Coupon $coupon) {
            $coupon->slug = $coupon->code;
        });
    }

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Determine coupon entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: fn () => [
                'url' => route('admin.coupons.show', [$this]),
                'label' => $this->code,
                'has_image' => false,
            ]
        );
    }
}
