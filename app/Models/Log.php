<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCreatorTrait;
use App\Traits\BelongsToUserTrait;
use App\Traits\TimezoneDateTrait;
use App\Enums\LogActionEnum;

class Log extends Model
{
    use HasUuids, HasFactory, BelongsToUserTrait, SoftDeletes, TimezoneDateTrait, BelongsToCreatorTrait;

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
                LogActionEnum::Custom => [
                    'value' => LogActionEnum::Custom->value,
                    'color' => 'secondary',
                ],
                LogActionEnum::Create => [
                    'value' => LogActionEnum::Create->value,
                    'color' => 'success',
                ],
            }
        );
    }
}
