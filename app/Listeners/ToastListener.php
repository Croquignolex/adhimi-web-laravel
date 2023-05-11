<?php

namespace App\Listeners;

use App\Enums\ToastTypeEnum;
use App\Events\ToastEvent;

class ToastListener
{
    /**
     * Handle the event.
     *
     * @param ToastEvent $event
     * @return void
     */
    public function handle(ToastEvent $event): void
    {
        $message = $event->message;
        $type = $event->type->value;

        switch ($event->type)
        {
            case ToastTypeEnum::Success:
                $this->toast($message, 'check', $type);
                break;
            case ToastTypeEnum::Info:
                $this->toast($message, 'alert-circle', $type);
                break;
            case ToastTypeEnum::Warning:
                $this->toast($message, 'alert-triangle', $type);
                break;
            case ToastTypeEnum::Danger:
                $this->toast($message, 'slash', $type);
                break;
        }
    }

    /**
     * @param string $message
     * @param string $icon
     * @param string $type
     * @return void
     */
    private function toast(string $message, string $icon, string $type): void
    {
        session()->flash('alert.icon', $icon);
        session()->flash('alert.type', $type);
        session()->flash('alert.message', $message);
    }
}
