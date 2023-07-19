<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\Models\GeneralStatusBadgeTrait;
use App\Traits\Models\BelongsToCustomerTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\EnableScopeTrait;
use App\Traits\Models\SearchScopeTrait;
use App\Enums\GeneralStatusEnum;

class Rating extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes,
        SearchScopeTrait,
        EnableScopeTrait,
        BelongsToCustomerTrait,
        GeneralStatusBadgeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
        'note',
        'status',

        'ratable_type',
        'ratable_id',

        'customer_id',
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
    protected $with = ['customer.avatar'];

    /**
     * The attributes that should be searchable.
     *
     * @var array<string>
     */
    protected array $searchFields = ['note'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Get the parent ratable models.
     *
     * @return MorphTo
     */
    public function ratable(): MorphTo
    {
        return $this->morphTo();
    }
}
