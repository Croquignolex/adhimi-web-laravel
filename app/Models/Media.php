<?php

namespace App\Models;

use App\Enums\MediaTypeEnum;
use App\Traits\Models\BelongsToCreatorTrait;
use App\Traits\Models\TimezoneDateTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes, HasUuids, BelongsToCreatorTrait, TimezoneDateTrait;

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
        'url',
        'description',

        'mediatable_type',
        'mediatable_id',

        'creator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => MediaTypeEnum::class,
    ];

    /**
     * Get the parent mediatable models.
     *
     * @return MorphTo
     */
    public function mediatable(): MorphTo
    {
        return $this->morphTo();
    }
}
