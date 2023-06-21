<?php

use App\Http\Controllers\Backoffice\Admin\OrganisationController;
use App\Http\Controllers\Backoffice\Admin\CountryController;
use App\Http\Controllers\Backoffice\Admin\ProfileController;
use App\Http\Controllers\Backoffice\Admin\StateController;
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
     * @middleware super,admin,merchant,manager,saler
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
    });

    /**
     * @middleware super,admin
     */
    Route::middleware('allow:super,admin')->group(function () {
        /**
         * @resource organisations
         * @controller organisations
         */
        Route::resource('organisations', OrganisationController::class)->except('destroy');
        Route::controller(OrganisationController::class)->prefix('organisations')->name('organisations.')->group(function () {
            Route::get('{country}/logs', 'showLogs')->name('show.logs');
            Route::put('{country}/change-logo', 'changeLogo')->name('logo.change');
            Route::delete('{country}/remove-logo', 'removeLogo')->name('logo.remove');
            Route::put('{country}/change-banner', 'changeBanner')->name('banner.change');
            Route::delete('{country}/remove-banner', 'removeBanner')->name('banner.remove');
            Route::post('{country}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{country}/add-shop', 'showAddShopForm')->name('add.shop');
            Route::post('{country}/add-shop', 'addShop');
            Route::get('{country}/add-vendor', 'showAddVendorForm')->name('add.vendor');
            Route::post('{country}/add-vendor', 'addVendor');
            Route::get('{country}/add-merchant', 'showAddMerchantForm')->name('add.merchant');
            Route::post('{country}/add-merchant', 'addMerchant');
            Route::get('{country}/add-manager', 'showAddManagerForm')->name('add.manager');
            Route::post('{country}/add-manager', 'addManager');
            Route::get('{country}/add-saler', 'showAddSalerForm')->name('add.saler');
            Route::post('{country}/add-saler', 'addSaler');
            Route::get('{country}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{country}/add-product', 'addProduct');
            Route::get('{country}/add-coupon', 'showAddCouponForm')->name('add.coupon');
            Route::post('{country}/add-coupon', 'addCoupon');
        });
    });

    /**
     * @middleware super,admin,merchant
     */
    Route::middleware('allow:super,admin,merchant')->group(function () {
        /**
         * @resource countries
         * @controller countries
         */
        Route::resource('countries', CountryController::class)->except('destroy');
        Route::controller(CountryController::class)->prefix('countries')->name('countries.')->group(function () {
            Route::get('{country}/logs', 'showLogs')->name('show.logs');
            Route::put('{country}/change-flag', 'changeFlag')->name('flag.change');
            Route::delete('{country}/remove-flag', 'removeFlag')->name('flag.remove');
            Route::post('{country}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{country}/add-state', 'showAddStateForm')->name('add.state');
            Route::post('{country}/add-state', 'addState');
        });

        /**
         * @resource states
         * @controller states
         */
        Route::resource('states', StateController::class)->except('destroy');
        Route::controller(StateController::class)->prefix('states')->name('states.')->group(function () {
            Route::get('{state}/logs', 'showLogs')->name('show.logs');
            Route::post('{state}/status-toggle', 'statusToggle')->name('status.toggle');
        });

        /**
         * @resource users
         * @controller users
         */
        Route::resource('users', UserController::class);
    });
});