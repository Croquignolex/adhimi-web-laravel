<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Enums\MiddlewareTypeEnum;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use Closure;

class RedirectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $type
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $type): Response|RedirectResponse
    {
        $authCheck = Auth::check();

        switch ($type) {
            case MiddlewareTypeEnum::Auth->value:
                if (!$authCheck) {
                    return redirect(route('customer.login'));
                }
                break;
            case MiddlewareTypeEnum::Guest->value:
                if ($authCheck) {
                    if (Auth::user()->hasRole([UserRoleEnum::Customer->value])) {
                        return redirect(route('customer.home'));
                    }

                    return redirect(route('admin.home'));
                }
                break;
        }

        return $next($request);
    }
}
