<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserStatusEnum;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use Illuminate\Http\Request;
use App\Events\ToastEvent;
use Illuminate\View\View;
use App\Events\LogEvent;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm():View
    {
        return view('backoffice.customer.auth.login');
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('customer.home');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return null|RedirectResponse
     */
    protected function authenticated(Request $request, User $user): null|RedirectResponse
    {
        $canLogin = (
            enums_equals($user->status, UserStatusEnum::Active) &&
            $this->hasRole([UserRoleEnum::Customer->value])
        );

        if($canLogin) {
            return $this->sendFailedLoginResponse($request);
        }

        $request->session()->put('language', $user->setting->language);

        LogEvent::dispatch($user, LogActionEnum::Auth, "Login", false);

        ToastEvent::dispatch("Welcome $user->first_name", ToastTypeEnum::Success);

        return null;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request): RedirectResponse
    {
        ToastEvent::dispatch("Incorrect credentials", ToastTypeEnum::Danger);

        return back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        LogEvent::dispatch($user, LogActionEnum::Auth, "Logout", false);

        $this->guard()->logout();

        $language = session('language', config('app.fallback_locale'));

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session(compact('language'));

        return redirect(route('login'));
    }
}
