<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\BelongsToStateTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AddressTypeEnum;

class Address extends Model
{
    use HasFactory, SoftDeletes, HasUuids, BelongsToCreatorTrait, BelongsToStateTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'street_address',
        'street_address_plus',
        'zipcode',
        'phone_number_one',
        'phone_number_two',
        'latitude',
        'longitude',
        'description',

        'addressable_type',
        'addressable_id',

        'creator_id',
        'state_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => AddressTypeEnum::class,
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['state.country', 'creator.avatar'];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllow(Builder $query): void
    {

    }

    /**
     * Get the parent addressable models.
     *
     * @return MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
