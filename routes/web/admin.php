<?php

use App\Http\Controllers\Backoffice\Admin\OrganisationController;
use App\Http\Controllers\Backoffice\Admin\ProfileController;
use App\Http\Controllers\Backoffice\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * @middleware auth
 */
Route::middleware('redirect:auth')->prefix('admin')->name('admin.')->group(function () {
    /**
     * @middleware super admin merchant manager saler
     */
    Route::middleware('allow:super,admin,merchant,manager,saler')->group(function () {
        /**
         * @view home
         */
        Route::view('home', 'backoffice.admin.home')->name('home');

        /**
         * @controller profile
         */
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('general', 'showInfoForm')->name('general');
            Route::put('general', 'infoUpdate');
            Route::get('settings', 'showSettingsForm')->name('settings');
            Route::put('settings', 'settingsUpdate');
            Route::view('password', 'backoffice.admin.profile.password')->name('password');
            Route::put('password', 'passwordUpdate');
            Route::get('address', 'showAddressForm')->name('address');
            Route::put('address', 'defaultAddressUpdate');
            Route::get('logs', 'showLogsForm')->name('logs');
            Route::get('avatar', 'showAvatarForm')->name('avatar');
            Route::put('avatar', 'avatarUpdate');
            Route::delete('avatar', 'avatarDelete');
        });

        /**
         * @middleware super
         */
        Route::middleware('allow:super')->group(function () {
            /**
             * @resource organisations
             */
            Route::resource('organisations', OrganisationController::class);
            /**
             * @controller organisation
             */
            Route::controller(OrganisationController::class)->prefix('organisations')->name('organisations.')->group(function () {
                Route::get('{organisation}/add-store', 'addStore')->name('add.store');
                Route::get('{organisation}/add-vendor', 'addVendor')->name('add.vendor');
                Route::get('{organisation}/add-merchant', 'addMerchant')->name('add.merchant');
            });
            /**
             * @resource users
             */
            Route::resource('users', UserController::class);
        });
    });
});