<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Enums\LanguageEnum;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // For the route to only consider known locale in segment
        Route::pattern('language', LanguageEnum::stringify('|'));

        $this->configureRateLimiting();

        $this->routes(function () {
            $this->apiRoutes();

            $this->webRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * @return void
     */
    private function apiRoutes(): void
    {
        $route = Route::middleware('api')->name('api.')->prefix('api/v1');

        $route->group(base_path('routes/api/shop.php'));
        $route->group(base_path('routes/api/auth.php'));
    }

    /**
     * @return void
     */
    private function webRoutes(): void
    {
        $route = Route::middleware('web');

        $route->group(base_path('routes/web/shop.php'));
        $route->group(base_path('routes/web/auth.php'));
        $route->group(base_path('routes/web/admin.php'));
        $route->group(base_path('routes/web/customer.php'));
    }
}
