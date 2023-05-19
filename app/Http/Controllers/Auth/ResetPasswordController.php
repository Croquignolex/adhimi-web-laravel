<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Events\LogEvent;
use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @param Request $request
     * @param $response
     * @return RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response): RedirectResponse
    {
        $user = $this->guard()->user();

        LogEvent::dispatch($user, LogActionEnum::Auth, "Password reset", false);

        ToastEvent::dispatch("Your password has been reset!", ToastTypeEnum::Success);

        $this->guard()->logout();

        return redirect(route('login'));
    }

    /**
     * @param Request $request
     * @param $response
     * @return RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response): RedirectResponse
    {
        $message = match ($response) {
            Password::INVALID_USER => "We can't find a user with that email address.",
            Password::INVALID_TOKEN => "This password reset token is invalid.",
        };

        ToastEvent::dispatch($message, ToastTypeEnum::Danger);

        return back();
    }
}
