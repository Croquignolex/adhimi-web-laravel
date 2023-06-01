<?php

namespace App\Traits;

use App\Http\Requests\Profile\UpdateAddressRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateSettingsRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Events\ToastEvent;
use App\Events\LogEvent;

trait ProfileTrait
{
    /**
     * Update profile info
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function infoUpdate(UpdateProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = Auth::user();

        $user->update([
            'slug' => $validated['first_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatch($user, LogActionEnum::Update, __('general.profile.profile_updated'));

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

                LogEvent::dispatch($user, LogActionEnum::Update, __('general.profile.password_updated'));
            }
            else {
                ToastEvent::dispatch(__('general.profile.incorrect_old_password'), ToastTypeEnum::Danger);
            }
        }

        return back();
    }

    /**
     * Update profile settings
     *
     * @param UpdateSettingsRequest $request
     * @return RedirectResponse
     */
    public function settingsUpdate(UpdateSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $enable_payement = nullable_params_value('enable_payement', $validated);
        $enable_purchase = nullable_params_value('enable_purchase', $validated);
        $enable_product = nullable_params_value('enable_product', $validated);
        $enable_customer = nullable_params_value('enable_customer', $validated);
        $enable_saler = nullable_params_value('enable_saler', $validated);
        $enable_manager = nullable_params_value('enable_manager', $validated);
        $enable_merchant = nullable_params_value('enable_merchant', $validated);
        $enable_admin = nullable_params_value('enable_admin', $validated);
        $enable_super_admin = nullable_params_value('enable_super_admin', $validated);

        $user = Auth::user();

        $user->setting()->update([
            'language' => $validated['language'],
            'timezone' => $validated['timezone'],

            'enable_action_on_super_admin_notification' => $enable_super_admin,
            'enable_action_on_admin_notification' => $enable_admin,
            'enable_action_on_manager_notification' => $enable_manager,
            'enable_action_on_merchant_notification' => $enable_merchant,
            'enable_action_on_saler_notification' => $enable_saler,
            'enable_action_on_customer_notification' => $enable_customer,

            'enable_product_notification' => $enable_product,
            'enable_purchase_notification' => $enable_purchase,
            'enable_payment_notification' => $enable_payement,
        ]);

        LogEvent::dispatch($user, LogActionEnum::Update, __('general.profile.settings_updated'));

        return back();
    }

    /**
     * Update profile default address
     *
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function defaultAddressUpdate(UpdateAddressRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = Auth::user();

        $address = Auth::user()->defaultAddress;

        if($address)
        {

        }
        else
        {

        }

        $user->update([
            'slug' => $validated['first_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatch($user, LogActionEnum::Update, __('general.profile.profile_updated'));

        return back();
    }
}
