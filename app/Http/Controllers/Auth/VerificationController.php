<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Events\LogEvent;
use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('home');
    }

    /**
     * @param Request $request
     * @return void.
     */
    protected function verified(Request $request): void
    {
        $user = $request->user();

        LogEvent::dispatch($user, LogActionEnum::Auth, "Verification", false);

        ToastEvent::dispatch("Email verified successfully", ToastTypeEnum::Success);
    }
}
