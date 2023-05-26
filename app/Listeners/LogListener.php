<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use App\Enums\ToastTypeEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;

class LogListener
{
    /**
     * Handle the event.
     *
     * @param LogEvent $event
     * @return void
     */
    public function handle(LogEvent $event): void
    {
        if($event->toast) {
            ToastEvent::dispatch($event->description, ToastTypeEnum::Success);
        }

        $event->model->loggers()->create([
            'creator_id' => Auth::id(),
            'action' => $event->action,
            'ip' => client_ip_address(),
            'description' => $event->description,
        ]);
    }
}
