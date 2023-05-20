<?php

namespace App\Http\Middleware;

use App\Enums\RedirectionMiddlewareTypeEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Enums\ToastTypeEnum;
use Illuminate\Http\Request;
use App\Events\ToastEvent;
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
         switch ($type) {
             case RedirectionMiddlewareTypeEnum::Auth->value:
                 if (!Auth::check()) {
                     return redirect(route('customer.login'));
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::Guest->value:
                 if (Auth::check()) {
                     if (Auth::user()->is_customer) {
                         return redirect(route('customer.home'));
                     }

                     return redirect(route('admin.home'));
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotSuperAdmin->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_super_admin) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotAdmin->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_admin) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotMerchant->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_merchant) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotShopManager->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_shop_manager) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotSaler->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_saler) {
                         $this->notAllowToast();
                         return back();
                     }
                 }
                 break;
             case RedirectionMiddlewareTypeEnum::NotCustomer->value:
                 if (Auth::check()) {
                     if(!Auth::user()->is_customer) {
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
