<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Enums\LogActionEnum;

class LogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        readonly public Model $model,
        readonly public Request $request,
        readonly public string $description,
        readonly public LogActionEnum $action
    ) {}

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @return array|null
     */
    public static function dispatchCreate(Model $model, Request $request, string $description): array|null
    {
        return self::dispatcheWithToast($model, $request, $description, LogActionEnum::Create);
    }

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @return array|null
     */
    public static function dispatchUpdate(Model $model, Request $request, string $description): array|null
    {
        return self::dispatcheWithToast($model, $request, $description, LogActionEnum::Update);
    }

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @return array|null
     */
    public static function dispatchDelete(Model $model, Request $request, string $description): array|null
    {
        return self::dispatcheWithToast($model, $request, $description, LogActionEnum::Delete);
    }

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @return array|null
     */
    public static function dispatchAuth(Model $model, Request $request, string $description): array|null
    {
        return event(new static($model, $request, $description, LogActionEnum::Auth));
    }

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @param bool $toast
     * @return array|null
     */
    public static function dispatchOther(Model $model, Request $request, string $description, bool $toast): array|null
    {
        return self::dispatcheWithToast($model, $request, $description, LogActionEnum::Other, $toast);
    }

    /**
     * @param Model $model
     * @param Request $request
     * @param string $description
     * @param bool $toast
     * @param LogActionEnum $action
     * @return array|null
     */
    private static function dispatcheWithToast(Model $model, Request $request, string $description, LogActionEnum $action, bool $toast = true): array|null
    {
        if($toast) ToastEvent::dispatchSuccess($description);

        return event(new static($model, $request, $description, $action));
    }
}
