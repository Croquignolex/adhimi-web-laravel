<?php

namespace App\Http\Controllers\Auth;

use App\Enums\GenderEnum;
use App\Enums\LogActionEnum;
use App\Enums\ToastTypeEnum;
use App\Events\LogEvent;
use App\Events\ToastEvent;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as MakeValidator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('login');
    }

    /**
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data): Validator
    {
        $genders = implode(',', GenderEnum::values());

        return MakeValidator::make($data, [
            'name' => "required|string|unique:users,name",
            'agree' => "required|string",
            'gender' => "required|in:$genders",
            'email' => "required|email|unique:users,email",
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
    }

    /**
     * @param  array  $validated
     * @return User
     */
    protected function create(array $validated): User
    {
        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'password' => $validated['password']
        ]);
    }

    /**
     * @param Request $request
     * @param $user
     * @return void.
     */
    protected function registered(Request $request, $user): void
    {
        $sponsorshipQuery = $request->query('sponsorship');

        if($sponsorshipQuery)
        {
            $referral = Referral::whereSlug($sponsorshipQuery)->first();
            if($referral)
            {
                $referral->sponsorships()->create([
                    'user_id' => $user->id
                ]);
            }
        }

        LogEvent::dispatch($user, LogActionEnum::Auth, "Register", false);

        ToastEvent::dispatch("Account created successfully", ToastTypeEnum::Success);

        $this->guard()->logout();
    }
}
