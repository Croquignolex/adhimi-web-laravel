<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait SearchScopeTrait
{
    /**
     * Scope a query to only include search model.
     */
    public function scopeSearch(Builder $query, string $q): void
    {
        $chainedBuilder = $query;
        $needles = explode(' ', $q);

        foreach ($needles as $key => $needle)
        {
            if($key === 0)
            {
                foreach ($this->searchFields as $index => $field)
                {
                    $chainedBuilder = ($index === 0)
                        ? $chainedBuilder->where($field, 'LIKE', "%$needle%")
                        : $chainedBuilder->orWhere($field, 'LIKE', "%$needle%");
                }
            }
            else
            {
                foreach ($this->searchFields as $key => $field) {
                    $chainedBuilder = $chainedBuilder->orWhere($field, 'LIKE', "%$needle%");
                }
            }
        }
    }
}
