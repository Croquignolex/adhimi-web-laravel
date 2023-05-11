<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

trait TimezoneDateTrait
{
    /**
     * Determine timezone creation date, magic attribute $this->tz_created_at.
     *
     * @return Attribute
     */
    public function tzCreatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->timezoneDate($this->created_at)
        );
    }

    /**
     * Determine timezone updating date, magic attribute $this->tz_updated_at.
     *
     * @return Attribute
     */
    public function tzUpdatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->timezoneDate($this->created_at)
        );
    }

    /**
     * Determine timezone deleting date, magic attribute $this->tz_deleted_at.
     *
     * @return Attribute
     */
    public function tzDeletedAt(): Attribute
    {
        return new Attribute(
            get: fn () => !is_null($this->deleted_at) ?: $this->timezoneDate($this->deleted_at)
        );
    }

    /**
     * @param Carbon $date
     * @return Carbon
     */
    public function timezoneDate(Carbon $date): Carbon
    {
        $timezone = Auth::user()->setting->timezone;
        return $date->timezone($timezone);
    }
}
