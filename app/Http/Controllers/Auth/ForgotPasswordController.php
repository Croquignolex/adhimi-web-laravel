<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ToastTypeEnum;
use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @param Request $request
     * @param $response
     * @return RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response): RedirectResponse
    {
        ToastEvent::dispatch("We have e-mailed your password reset link!", ToastTypeEnum::Success);

        return back();
    }

    /**
     * @param Request $request
     * @param $response
     * @return RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response): RedirectResponse
    {
        $message = match ($response) {
            Password::INVALID_USER => "We can't find a user with that email address.",
            Password::RESET_THROTTLED => "Please wait before retrying.",
        };

        ToastEvent::dispatch($message, ToastTypeEnum::Danger);

        return back();
    }
}
