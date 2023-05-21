<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserStatusEnum;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use Illuminate\Http\Request;
use App\Enums\LanguageEnum;
use App\Events\ToastEvent;
use Illuminate\View\View;
use App\Events\LogEvent;
use App\Models\User;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm():View
    {
        return view('backoffice.admin.auth.login');
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('admin.home');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return null|string
     */
    protected function authenticated(Request $request, User $user): null|string
    {
        $canLogin = (
            enums_equals($user->status, UserStatusEnum::Active) &&
            !$user->is_customer
        );

        if($canLogin) {
            return 'auth.failed';
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
        ToastEvent::dispatch(
            __('general.login.invalid_credentials'),
            ToastTypeEnum::Danger
        );

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

        $language = $request->session()->get('language', LanguageEnum::French->value);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->put('language', $language);

        return redirect(route('admin.login'));
    }
}
