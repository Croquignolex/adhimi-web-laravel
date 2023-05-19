<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Enums\UserStatusEnum;
use App\Events\LogEvent;
use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        return route('home');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return null|RedirectResponse
     */
    protected function authenticated(Request $request, User $user): null|RedirectResponse
    {
        LogEvent::dispatch($user, LogActionEnum::Auth, "Login", false);

        if(!enums_equals($user->status, UserStatusEnum::Active)) {
            return redirect(route('blocked'));
        }

        // Apply user settings
        $setting = $user->setting;
        session(['language' => $setting->language]);

        ToastEvent::dispatch("Welcome $user->name", ToastTypeEnum::Success);

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
