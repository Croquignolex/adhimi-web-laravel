<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait SlugFromNameTrait
{
    use RouteSlugTrait;

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
}
