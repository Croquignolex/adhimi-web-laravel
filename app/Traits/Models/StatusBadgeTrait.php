<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\GeneralStatusEnum;

trait StatusBadgeTrait
{
    /**
     * Determine model's status badge, magic attribute $this->status_badge.
     *
     * @return Attribute
     */
    protected function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->status) {
                GeneralStatusEnum::Enable => [
                    'value' => __('general.status.' . GeneralStatusEnum::Enable->value),
                    'color' => 'success',
                ],
                GeneralStatusEnum::Disable => [
                    'value' => __('general.status.' . GeneralStatusEnum::Disable->value),
                    'color' => 'danger',
                ],
                GeneralStatusEnum::StandBy => [
                    'value' => __('general.status.' . GeneralStatusEnum::StandBy->value),
                    'color' => 'warning',
                ],
                default => [
                    'value' => __('general.status.unknown'),
                    'color' => 'secondary',
                ]
            }
        );
    }
}
