<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait SlugFromNameTrait
{
    /**
     * @return void
     */
    public static function bootSlugFromNameTrait(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->name;
        });

        static::updating(function (Model $model) {
            $model->slug = $model->name;
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
