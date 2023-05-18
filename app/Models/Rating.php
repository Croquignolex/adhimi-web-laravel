<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUserTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\GeneralStatusEnum;

class Rating extends Model
{
    use HasFactory, SoftDeletes, HasUuids, BelongsToUserTrait, TimezoneDateTrait;

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

        'user_id',
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
     * Get the parent ratable models.
     *
     * @return MorphTo
     */
    public function ratable(): MorphTo
    {
        return $this->morphTo();
    }
}
