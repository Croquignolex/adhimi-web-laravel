<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Events\Registered;
use App\Observers\PaymentObserver;
use App\Observers\InvoiceObserver;
use App\Listeners\ToastListener;
use App\Observers\UserObserver;
use App\Listeners\LogListener;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        ToastEvent::class => [ToastListener::class],
        LogEvent::class => [LogListener::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
