<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
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

        // Morph names mapping
        Relation::enforceMorphMap([
            'user' => User::class,
            'payment' => Payment::class,
            'invoice' => Invoice::class,
        ]);
    }
}
