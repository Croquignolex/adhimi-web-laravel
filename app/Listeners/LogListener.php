<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
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
        $event->model->logs()->create([
            'creator_id' => Auth::id(),
            'action' => $event->action,
            'ip' => $event->request->ip(),
            'description' => $event->description,
        ]);
    }
}
