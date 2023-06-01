<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait TimezonePromotionDateTrait
{
    /**
     * Determine timezone promotion stared at, magic attribute $this->tz_promotion_started_at.
     *
     * @return Attribute
     */
    protected function TzPromotionStartedAt(): Attribute
    {
        $field = $this->promotion_started_at;
        return new Attribute(
            get: fn () => is_null($field) ? $field : $this->timezoneDate($field)
        );
    }

    /**
     * Determine timezone promotion ended at, magic attribute $this->tz_promotion_ended_at.
     *
     * @return Attribute
     */
    protected function TzPromotionEndedAt(): Attribute
    {
        $field = $this->promotion_ended_at;
        return new Attribute(
            get: fn () => is_null($field) ? $field : $this->timezoneDate($field)
        );
    }
}
