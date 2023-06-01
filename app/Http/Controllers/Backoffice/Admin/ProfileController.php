<?php

namespace App\Http\Controllers\Backoffice\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ProfileTrait;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ProfileTrait;

    /**
     * Show update profile info form
     *
     * @return View
     */
    public function showInfoForm(): View
    {
        $user = Auth::user();

        return view('backoffice.admin.profile.index', compact('user'));
    }

    /**
     * Show update settings info form
     *
     * @return View
     */
    public function showSettingsForm(): View
    {
        $user = Auth::user()->load('setting');

        $setting = $user->setting;

        return view('backoffice.admin.profile.settings', compact('setting', 'user'));
    }

    /**
     * Show update address form
     *
     * @return View
     */
    public function showAddressForm(): View
    {
        $address = Auth::user()->defaultAddress;

        return view('backoffice.admin.profile.address', compact('address'));
    }

    /**
     * Show user log activities
     *
     * @return View
     */
    public function showLogsForm(): View
    {
        $logs = Auth::user()->logs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.profile.logs', compact('logs'));
    }
}
