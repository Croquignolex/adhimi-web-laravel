<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Enums\UserStatusEnum;
use Illuminate\Http\Request;
use App\Enums\UserRoleEnum;
use App\Traits\LoginTrait;
use Illuminate\View\View;
use App\Models\User;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers, LoginTrait {
        LoginTrait::sendFailedLoginResponse insteadof AuthenticatesUsers;
        LoginTrait::logout insteadof AuthenticatesUsers;
    }

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
     * The user has been authenticated.
     *
     * @param Request $request
     * @param User $user
     * @return null|RedirectResponse
     */
    protected function authenticated(Request $request, User $user): null|RedirectResponse
    {
        $canLogin = (
            enums_equals($user->status, UserStatusEnum::Active) &&
            $user->hasRole([
                UserRoleEnum::ShopManager->value,
                UserRoleEnum::SuperAdmin->value,
                UserRoleEnum::Merchant->value,
                UserRoleEnum::Admin->value,
                UserRoleEnum::Saler->value,
            ])
        );

        return $this->authenticatedProcess($request, $user, $canLogin);
    }

    /**
     * The user has logged out of the application.
     *
     * @return RedirectResponse
     */
    protected function loggedOut(): RedirectResponse
    {
        return redirect(route('admin.login'));
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return route('admin.home');
    }
}
