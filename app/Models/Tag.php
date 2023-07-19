<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Models\EnableScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GeneralStatusEnum;

class Tag extends Model
{
    use HasFactory, BelongsToCreatorTrait, HasUuids, EnableScopeTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',

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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['creator.avatar'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Get all groups that are assigned this tag.
     *
     * @return MorphToMany
     */
    public function groups(): MorphToMany
    {
        return $this->morphedByMany(Group::class, 'taggable');
    }
}
