<?php

namespace App\Traits;

use App\Enums\LanguageEnum;
use App\Enums\LogActionEnum;
use App\Events\LogEvent;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Enums\ToastTypeEnum;
use Illuminate\Http\Request;
use App\Events\ToastEvent;
use Illuminate\Support\Facades\Auth;

trait LoginTrait
{
    /**
     * @param Request $request
     * @param User $user
     * @param bool $canLogin
     * @return RedirectResponse|null
     */
    protected function authenticatedProcess(Request $request,  User $user, bool $canLogin): null|RedirectResponse
    {
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

        return $this->loggedOut();
    }
}
