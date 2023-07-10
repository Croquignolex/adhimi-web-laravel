<?php

use App\Http\Controllers\Backoffice\Admin\OrganisationController;
use App\Http\Controllers\Backoffice\Admin\CategoryController;
use App\Http\Controllers\Backoffice\Admin\CountryController;
use App\Http\Controllers\Backoffice\Admin\ProfileController;
use App\Http\Controllers\Backoffice\Admin\CouponController;
use App\Http\Controllers\Backoffice\Admin\BrandController;
use App\Http\Controllers\Backoffice\Admin\StateController;
use App\Http\Controllers\Backoffice\Admin\GroupController;
use App\Http\Controllers\Backoffice\Admin\ShopController;
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

        /**
         * @resource users
         * @controller users
         */
        Route::resource('users', UserController::class);
    });

    /**
     * @middleware super,admin,merchant,manager
     */
    Route::middleware('allow:super,admin,merchant,manager')->group(function () {
        /**
         * @resource brands
         * @controller brands
         */
        Route::resource('brands', BrandController::class)->except('destroy');
        Route::controller(BrandController::class)->prefix('brands')->name('brands.')->group(function () {
            Route::get('{brand}/logs', 'showLogs')->name('show.logs');
            Route::put('{brand}/change-logo', 'changeLogo')->name('logo.change');
            Route::delete('{brand}/remove-logo', 'removeLogo')->name('logo.remove');
            Route::post('{brand}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{brand}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{brand}/add-product', 'addProduct');
        });

        /**
         * @resource groups
         * @controller groups
         */
        Route::resource('groups', GroupController::class)->except('destroy');
        Route::controller(GroupController::class)->prefix('groups')->name('groups.')->group(function () {
            Route::get('{group}/logs', 'showLogs')->name('show.logs');
            Route::get('{group}/products', 'showProducts')->name('show.products');
            Route::put('{group}/change-banner', 'changeBanner')->name('banner.change');
            Route::delete('{group}/remove-banner', 'removeBanner')->name('banner.remove');
            Route::post('{group}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{group}/add-category', 'showAddCategoryForm')->name('add.category');
            Route::post('{group}/add-category', 'addCategory');
            Route::get('{group}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{group}/add-product', 'addProduct');
        });

        /**
         * @resource categories
         * @controller categories
         */
        Route::resource('categories', CategoryController::class)->except('destroy');
        Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
            Route::get('{category}/logs', 'showLogs')->name('show.logs');
            Route::put('{category}/change-banner', 'changeBanner')->name('banner.change');
            Route::delete('{category}/remove-banner', 'removeBanner')->name('banner.remove');
            Route::post('{category}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{category}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{category}/add-product', 'addProduct');
        });

        /**
         * @resource categories
         * @controller categories
         */
        Route::resource('categories', CategoryController::class)->except('destroy');
        Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
            Route::get('{category}/logs', 'showLogs')->name('show.logs');
            Route::put('{category}/change-banner', 'changeBanner')->name('banner.change');
            Route::delete('{category}/remove-banner', 'removeBanner')->name('banner.remove');
            Route::post('{category}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{category}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{category}/add-product', 'addProduct');
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
         * @resource shops
         * @controller shops
         */
        Route::resource('shops', ShopController::class)->except('destroy');
        Route::controller(ShopController::class)->prefix('shops')->name('shops.')->group(function () {
            Route::get('{shop}/logs', 'showLogs')->name('show.logs');
            Route::post('{shop}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{shop}/address', 'showAddressForm')->name('address');
            Route::post('{shop}/address', 'defaultAddressUpdate');
            Route::get('{shop}/add-manager', 'showAddManagerForm')->name('add.manager');
            Route::post('{shop}/add-manager', 'addManager');
            Route::get('{shop}/add-seller', 'showAddSellerForm')->name('add.seller');
            Route::post('{shop}/add-seller', 'addSeller');
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
            Route::get('{organisation}/logs', 'showLogs')->name('show.logs');
            Route::get('{organisation}/vendors', 'showVendors')->name('show.vendors');
            Route::get('{organisation}/coupons', 'showCoupons')->name('show.coupons');
            Route::get('{organisation}/users', 'showUsers')->name('show.users');
            Route::get('{organisation}/products', 'showProducts')->name('show.products');
            Route::put('{organisation}/change-logo', 'changeLogo')->name('logo.change');
            Route::delete('{organisation}/remove-logo', 'removeLogo')->name('logo.remove');
            Route::put('{organisation}/change-banner', 'changeBanner')->name('banner.change');
            Route::delete('{organisation}/remove-banner', 'removeBanner')->name('banner.remove');
            Route::post('{organisation}/status-toggle', 'statusToggle')->name('status.toggle');
            Route::get('{organisation}/add-shop', 'showAddShopForm')->name('add.shop');
            Route::post('{organisation}/add-shop', 'addShop');
            Route::get('{organisation}/add-vendor', 'showAddVendorForm')->name('add.vendor');
            Route::post('{organisation}/add-vendor', 'addVendor');
            Route::get('{organisation}/add-merchant', 'showAddMerchantForm')->name('add.merchant');
            Route::post('{organisation}/add-merchant', 'addMerchant');
            Route::get('{organisation}/add-manager', 'showAddManagerForm')->name('add.manager');
            Route::post('{organisation}/add-manager', 'addManager');
            Route::get('{organisation}/add-seller', 'showAddSellerForm')->name('add.seller');
            Route::post('{organisation}/add-seller', 'addSeller');
            Route::get('{organisation}/add-product', 'showAddProductForm')->name('add.product');
            Route::post('{organisation}/add-product', 'addProduct');
            Route::get('{organisation}/add-coupon', 'showAddCouponForm')->name('add.coupon');
            Route::post('{organisation}/add-coupon', 'addCoupon');
        });

        /**
         * @resource coupons
         * @controller coupons
         */
        Route::resource('coupons', CouponController::class)->except('destroy');
        Route::controller(CouponController::class)->prefix('coupons')->name('coupons.')->group(function () {
            Route::get('{coupon}/logs', 'showLogs')->name('show.logs');
            Route::post('{coupon}/status-toggle', 'statusToggle')->name('status.toggle');
        });
    });
});