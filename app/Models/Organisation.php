<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\MorphOneBannerTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\NameInitialsTrait;
use App\Traits\Models\HasManyUsersTrait;
use App\Traits\Models\MorphOneLogoTrait;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\StatusBadgeTrait;
use App\Enums\GeneralStatusEnum;
use App\Enums\UserRoleEnum;

class Organisation extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        StatusBadgeTrait,
        EnableScopeTrait,
        HasManyUsersTrait,
        MorphOneLogoTrait,
        NameInitialsTrait,
        MorphOneBannerTrait,
        BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'website',
        'phone',
        'status',
        'description',

        'creator_id'
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
     * Scope a query to only include search model.
     */
    public function scopeSearch(Builder $query, string $q): void
    {
        $query->where('name', 'LIKE', "%$q%")
            ->orWhere('email', 'LIKE', "%$q%")
            ->orWhere('phone', 'LIKE', "%$q%");
    }

    /**
     * Get merchant associated with the organisation.
     *
     * @return HasOne
     */
    public function merchant(): HasOne
    {
        return $this->hasOne(User::class)->whereHas('roles', function (Builder $query) {
            $query->where('name', UserRoleEnum::Merchant->value);
        });
    }

    /**
     * Get shops associated with the organisations.
     *
     * @return HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * Get vendors associated with the organisations.
     *
     * @return HasMany
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }
}
