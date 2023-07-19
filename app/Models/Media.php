<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MediaTypeEnum;

class Media extends Model
{
    use HasFactory, SoftDeletes, HasUuids, BelongsToCreatorTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'location',
        'is_local',
        'description',

        'mediatable_type',
        'mediatable_id',

        'creator_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['creator.avatar'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => MediaTypeEnum::class,
        'is_local' => 'boolean',
    ];

    /**
     * Scope a query to only include allowed model.
     */
    public function scopeAllowed(Builder $query): void
    {

    }

    /**
     * Get the parent mediatable models.
     *
     * @return MorphTo
     */
    public function mediatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Determine media url, magic attribute $this->url.
     *
     * @return Attribute
     */
    protected function url(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->is_local) {
                    return Storage::disk('public')->url($this->name);
                }

                return $this->location;
            }
        );
    }
}
