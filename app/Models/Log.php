<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\BelongsToCreatorTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LogActionEnum;

class Log extends Model
{
    use HasUuids, HasFactory, SoftDeletes, BelongsToCreatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'action',
        'description',

        'loggable_type',
        'loggable_id',

        'creator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'action' => LogActionEnum::class,
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
     * Get the parent loggable models.
     *
     * @return MorphTo
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Determine log action badge, magic attribute $this->action_badge.
     *
     * @return Attribute
     */
    protected function actionBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->action) {
                LogActionEnum::Delete => [
                    'value' => LogActionEnum::Delete->value,
                    'color' => 'danger',
                ],
                LogActionEnum::Auth => [
                    'value' => LogActionEnum::Auth->value,
                    'color' => 'info',
                ],
                LogActionEnum::Update => [
                    'value' => LogActionEnum::Update->value,
                    'color' => 'warning',
                ],
                LogActionEnum::Create => [
                    'value' => LogActionEnum::Create->value,
                    'color' => 'success',
                ],
                default =>  [
                    'value' => LogActionEnum::Other->value,
                    'color' => 'secondary',
                ],
            }
        );
    }

    /**
     * Determine log entity, magic attribute $this->entity.
     *
     * @return Attribute
     */
    protected function entity(): Attribute
    {
        return new Attribute(
            get: function () {
                if(enums_equals($this->action, LogActionEnum::Auth) || enums_equals($this->action, LogActionEnum::Other)) {
                    return null;
                }

                return $this->loggable;
            }
        );
    }
}
