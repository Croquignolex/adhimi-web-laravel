<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Models\AttributeValue;
use App\Models\Organisation;
use App\Models\Attribute;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\Coupon;
use App\Models\Brand;
use App\Models\Group;
use App\Models\State;
use App\Models\User;
use App\Models\Shop;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default morph key
        Builder::defaultMorphKeyType('uuid');

        // No data wrapper for api resources
        JsonResource::withoutWrapping();

        // Morph names mapping
        Relation::enforceMorphMap([
            'user' => User::class,
            'shop' => Shop::class,
            'brand' => Brand::class,
            'group' => Group::class,
            'state' => State::class,
            'vendor' => Vendor::class,
            'coupon' => Coupon::class,
            'country' => Country::class,
            'category' => Category::class,
            'customer' => Customer::class,
            'attribute' => Attribute::class,
            'organisation' => Organisation::class,
            'attribute-value' => AttributeValue::class,
        ]);
    }
}
