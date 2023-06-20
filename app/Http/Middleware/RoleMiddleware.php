<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Enums\MiddlewareTypeEnum;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Events\ToastEvent;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null ...$types
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ?string ...$types): Response|RedirectResponse
    {
        $mappedTypes = collect($types)->map(fn (string $type) => match ($type) {
            MiddlewareTypeEnum::Customer->value => UserRoleEnum::Customer->value,
            MiddlewareTypeEnum::Admin->value => UserRoleEnum::Admin->value,
            MiddlewareTypeEnum::Merchant->value => UserRoleEnum::Merchant->value,
            MiddlewareTypeEnum::ShopManager->value => UserRoleEnum::ShopManager->value,
            MiddlewareTypeEnum::Saler->value => UserRoleEnum::Saler->value,
            default => UserRoleEnum::SuperAdmin->value,
        })->all();

        if(Auth::check() && !Auth::user()->hasRole($mappedTypes))
        {
            ToastEvent::dispatchWarning(__('general.permission_denied'));
            return back();
        }

        return $next($request);
    }
}
