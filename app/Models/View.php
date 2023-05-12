<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUserTrait;
use App\Traits\TimezoneDateTrait;

class View extends Model
{
    use HasFactory, BelongsToUserTrait, SoftDeletes, HasUuids, TimezoneDateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'viewable_type',
        'viewable_id',

        'user_id',
    ];

    /**
     * Get the parent viewable models.
     *
     * @return MorphTo
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
