<?php

namespace App\Http\Controllers\Backoffice\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Events\ToastEvent;
use Illuminate\View\View;
use App\Events\LogEvent;

class ProfileController extends Controller
{
    /**
     * Show update profile info form
     *
     * @return View
     */
    public function infoShowForm(): View
    {
        $user = Auth::user();

        return view('backoffice.admin.profile.index', compact('user'));
    }

    /**
     * Update profile info
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function infoUpdate(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validated();

        $user->update([
            'slug' => $validated['first_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatch($user, LogActionEnum::Custom, __('general.profile.profile_updated'));

        return back();
    }

    /**
     * Update password
     *
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function passwordUpdate(UpdatePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $old_password = $validated['old_password'];
        $password = $validated['password'];

        if ($password === $old_password) {
            ToastEvent::dispatch(__('general.profile.identical_passwords'), ToastTypeEnum::Danger);
        }
        else
        {
            $user = Auth::user();

            if (Hash::check($old_password, $user->password))
            {
                $user->update(['password' => Hash::make($password)]);

                LogEvent::dispatch($user, LogActionEnum::Custom, __('general.profile.password_updated'));
            }
            else {
                ToastEvent::dispatch(__('general.profile.incorrect_old_password'), ToastTypeEnum::Danger);
            }
        }

        return back();
    }
}
