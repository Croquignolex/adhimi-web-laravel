<?php

namespace App\Traits;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateSettingsRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdateAddressRequest;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\MediaTypeEnum;
use Illuminate\Http\Request;
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

        $authUser = Auth::user();

        $authUser->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'profession' => $validated['profession'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'description' => $validated['description'],
        ]);

        LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_updated'));

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
            ToastEvent::dispatchDanger(__('general.profile.identical_passwords'));
        }
        else
        {
            $authUser = Auth::user();

            if (Hash::check($old_password, $authUser->password))
            {
                $authUser->update(['password' => Hash::make($password)]);

                LogEvent::dispatchOther($authUser, $request, __('general.profile.password_updated'));
            }
            else {
                ToastEvent::dispatchDanger(__('general.profile.incorrect_old_password'));
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

        $authUser = Auth::user();

        $authUser->setting()->update([
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

        LogEvent::dispatchOther($authUser, $request, __('general.profile.settings_updated'));

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

        $authUser = Auth::user();

        $address = $authUser->defaultAddress;

        if($address)
        {
            $address->update([
                'street_address' => $validated['street_address'],
                'street_address_plus' => $validated['street_address_plus'],
                'zipcode' => $validated['zipcode'],
                'phone_number_one' => $validated['phone_number_one'],
                'phone_number_two' => $validated['phone_number_two'],
                'description' => $validated['description'],
                'state_id' => $validated['state'],
            ]);

            LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_default_address_updated'));
        }
        else
        {
            $authUser->defaultAddress()->create([
                'street_address' => $validated['street_address'],
                'street_address_plus' => $validated['street_address_plus'],
                'zipcode' => $validated['zipcode'],
                'phone_number_one' => $validated['phone_number_one'],
                'phone_number_two' => $validated['phone_number_two'],
                'description' => $validated['description'],
                'state_id' => $validated['state'],
                'creator_id' => $authUser->id,
            ]);

            LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_default_address_created'));
        }

        return back();
    }

    /**
     * Update profile avatar
     *
     * @param UpdateAvatarRequest $request$
     * @return RedirectResponse
     */
    public function avatarUpdate(UpdateAvatarRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $authUser = Auth::user();

        $avatar = $authUser->avatar;

        $avatarName = Storage::disk('public')->put(MediaTypeEnum::Avatar->value, $validated['avatar']);

        if($avatarName)
        {
            if($avatar)
            {
                $avatar->update(['name' => $avatarName]);

                LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_avatar_updated'));
            }
            else
            {
                $authUser->avatar()->create([
                    'name' => $avatarName,
                    'type' => MediaTypeEnum::Avatar,
                    'creator_id' => $authUser->id,
                ]);

                LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_avatar_created'));
            }
        } else {
            ToastEvent::dispatchDanger(__('general.upload_error'));
        }

        return back();
    }

    /**
     * Delete profile avatar
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function avatarDelete(Request $request): RedirectResponse
    {
        $authUser = Auth::user();

        $authUser->avatar()->delete();

        LogEvent::dispatchOther($authUser, $request, __('general.profile.profile_avatar_deleted'));

        return back();
    }
}
