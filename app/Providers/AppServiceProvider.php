<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Models\Organisation;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;

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
            'payment' => Payment::class,
            'invoice' => Invoice::class,
            'organisation' => Organisation::class,
        ]);
    }
}
