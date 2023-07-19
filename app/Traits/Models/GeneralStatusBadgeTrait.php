<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\GeneralStatusEnum;

trait GeneralStatusBadgeTrait
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

    /**
     * Determine model's status toggle, magic attribute $this->status_toggle.
     *
     * @return Attribute
     */
    protected function statusToggle(): Attribute
    {
        $name = $this->name ?: $this->code;

        return new Attribute(
            get: fn () => match ($this->status) {
                GeneralStatusEnum::Enable => [
                    'label' => __('general.action.disable'),
                    'message' => __('general.enable_toggle', ['name' => $name]),
                    'color' => 'danger',
                    'icon' => 'lock',
                    'next' => GeneralStatusEnum::Disable,
                ],
                default => [
                    'label' => __('general.action.enable'),
                    'message' => __('general.disable_toggle', ['name' => $name]),
                    'color' => 'success',
                    'icon' => 'unlock',
                    'next' => GeneralStatusEnum::Enable,
                ]
            }
        );
    }
}
