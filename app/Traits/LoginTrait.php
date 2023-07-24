<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\LanguageEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;
use App\Models\User;

trait LoginTrait
{
    /**
     * @param Request $request
     * @param User $user
     * @param bool $canLogin
     * @return RedirectResponse|null
     */
    protected function authenticatedProcess(Request $request, User $user, bool $canLogin): null|RedirectResponse
    {
        if(!$canLogin) {
            $this->guard()->logout();
            return $this->sendFailedLoginResponse();
        }

        $request->session()->put('language', $user->setting->language->value);

        LogEvent::dispatchAuth($user, $request, __('page.login'));

        ToastEvent::dispatchSuccess(__('general.login.welcome_name', ['name' => $user->name]));

        return null;
    }

    /**
     * Get the failed login response instance.
     *
     * @return RedirectResponse
     */
    protected function sendFailedLoginResponse(): RedirectResponse
    {
        ToastEvent::dispatchDanger(__('general.login.invalid_credentials'));

        return back();
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        LogEvent::dispatchAuth($user, $request, __('page.logout'));

        $this->guard()->logout();

        $language = $request->session()->get('language', LanguageEnum::French->value);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->put('language', $language);

        return $this->loggedOut();
    }
}
