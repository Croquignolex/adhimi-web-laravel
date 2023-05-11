<?php

namespace App\Http\Middleware;

use App\Enums\RedirectionMiddlewareTypeEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Enums\UserStatusEnum;
use App\Enums\ToastTypeEnum;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Events\ToastEvent;
use Closure;

class RedirectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param RedirectionMiddlewareTypeEnum $type
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, RedirectionMiddlewareTypeEnum $type): Response|RedirectResponse
    {
         switch ($type) {
             case RedirectionMiddlewareTypeEnum::Active->value:
                 if (Auth::check()) {
                     if (enums_equals(Auth::user()?->status, UserStatusEnum::Active)) {
                         return redirect(route('home'));
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::Auth->value:
                 if (Auth::check()) {
                     return redirect(route('home'));
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::Guest->value:
                 if (Auth::check()) {
                     if (!enums_equals(Auth::user()?->status,UserStatusEnum::Active)) {
                         return redirect(route('blocked'));
                     } else {
                         return redirect(route('login'));
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotAdmin->value:
                 if (Auth::check()) {
                     if(!Auth::user()->hasRole([UserRoleEnum::Admin->value])) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotSuperAdmin->value:
                 if (Auth::check()) {
                     if(!Auth::user()->hasRole([UserRoleEnum::SuperAdmin->value])) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotShopManager->value:
                 if (Auth::check()) {
                     if(!Auth::user()->hasRole([UserRoleEnum::ShopManager->value])) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotMerchant->value:
                 if (Auth::check()) {
                     if(!Auth::user()->hasRole([UserRoleEnum::Merchant->value])) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotSaler->value:
                 if (Auth::check()) {
                     if(!Auth::user()->hasRole([UserRoleEnum::Saler->value])) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
         }

        return $next($request);
    }

    /**
     * @return void
     */
    private function notAllowToast(): void
    {
        ToastEvent::dispatch(
            "You are not allow to perform this action",
            ToastTypeEnum::Warning
        );
    }
}
