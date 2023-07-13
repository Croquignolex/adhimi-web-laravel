<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\UserStatusEnum;

trait UserStatusBadgeTrait
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
                UserStatusEnum::Active => [
                    'value' => __('general.status.' . UserStatusEnum::Active->value),
                    'color' => 'success',
                ],
                UserStatusEnum::Blocked => [
                    'value' => __('general.status.' . UserStatusEnum::Blocked->value),
                    'color' => 'danger',
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
        $name = $this->first_name ?: $this->name;

        return new Attribute(
            get: fn () => match ($this->status) {
                UserStatusEnum::Active => [
                    'label' => __('general.action.disable'),
                    'message' => __('general.enable_toggle', ['name' => $name]),
                    'color' => 'danger',
                    'icon' => 'lock',
                    'next' => UserStatusEnum::Blocked,
                ],
                default => [
                    'label' => __('general.action.enable'),
                    'message' => __('general.disable_toggle', ['name' => $name]),
                    'color' => 'success',
                    'icon' => 'unlock',
                    'next' => UserStatusEnum::Active,
                ]
            }
        );
    }
}
