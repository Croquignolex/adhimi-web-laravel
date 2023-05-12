<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUserTrait;
use App\Traits\TimezoneDateTrait;

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

        'ratable_type',
        'ratable_id',

        'user_id',
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
