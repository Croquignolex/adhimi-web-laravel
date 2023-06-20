<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Enums\ToastTypeEnum;

class ToastEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        readonly public string $message,
        readonly public ToastTypeEnum $type
    ) {}

    /**
     * @param string $message
     * @return array|null
     */
    public static function dispatchInfo(string $message): array|null
    {
        return event(new static($message, ToastTypeEnum::Info));
    }

    /**
     * @param string $message
     * @return array|null
     */
    public static function dispatchWarning(string $message): array|null
    {
        return event(new static($message, ToastTypeEnum::Warning));
    }

    /**
     * @param string $message
     * @return array|null
     */
    public static function dispatchDanger(string $message): array|null
    {
        return event(new static($message, ToastTypeEnum::Danger));
    }

    /**
     * @param string $message
     * @return array|null
     */
    public static function dispatchSuccess(string $message): array|null
    {
        return event(new static($message, ToastTypeEnum::Success));
    }
}
