<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait UniqueSlugTrait
{
    /**
     * Set the proper slug attribute.
     *
     * @return Attribute
     */
    public function slug(): Attribute
    {
        return new Attribute(
            set: function (string $value) {
                 $nextSlug = Str::slug($value);

                if($this->slug === $nextSlug) {
                    return $nextSlug;
                }

                return $this->uniqueSlug($nextSlug);
            }
        );
    }

    /**
     * Increment slug
     *
     * @param string $originalSlug
     * @param int $rank
     * @return string
     */
    private function uniqueSlug(string $originalSlug, int $rank = 0): string
    {
        $slug = $rank === 0 ? $originalSlug : "$originalSlug-$rank";

        if (static::whereNotIn('id', [$this->id])->whereSlug($slug)->exists()) {
            return $this->uniqueSlug($originalSlug,$rank + 1);
        } else {
            return "$slug";
        }
    }
}
