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
        $needles = explode(' ', $q);

        foreach ($needles as $key => $needle)
        {
            if($key === 0)
            {
                foreach ($this->searchFields as $index => $field)
                {
                    if($index === 0) $query->where($field, 'LIKE', "%$needle%");
                    else $query->orWhere($field, 'LIKE', "%$needle%");
                }
            }
            else
            {
                foreach ($this->searchFields as $field) {
                    $query->orWhere($field, 'LIKE', "%$needle%");
                }
            }
        }
    }
}
