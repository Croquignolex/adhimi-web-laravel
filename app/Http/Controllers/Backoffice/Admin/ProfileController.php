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
        $user = Auth::user()->load(['organisation', 'shop']);

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

        return view('backoffice.admin.profile.settings', compact('user'));
    }

    /**
     * Show update avatar form
     *
     * @return View
     */
    public function showAvatarForm(): View
    {
        $user = Auth::user();

        return view('backoffice.admin.profile.avatar', compact('user'));
    }

    /**
     * Show user log activities
     *
     * @return View
     */
    public function showLogsForm(): View
    {
        $logs = Auth::user()->createdLogs()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.profile.logs', compact('logs'));
    }
}
