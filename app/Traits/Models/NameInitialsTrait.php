<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait NameInitialsTrait
{
    /**
     * Determine model initials, magic attribute $this->initials.
     *
     * @return Attribute
     */
    protected function initials(): Attribute
    {
        return new Attribute(
            get: function () {
                $name = strtoupper($this->name);
                $nameArray = explode(' ', $name);

                if(count($nameArray) > 1) {
                    return mb_substr($nameArray[0], 0, 1) . mb_substr($nameArray[1], 0, 1);
                }
                return mb_substr($nameArray[0], 0, 2);
            }
        );
    }
}
