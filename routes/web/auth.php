<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * @middleware guest
 */
Route::middleware('redirect:guest')->group(function () {
    /**
     * @prefix admin
     * @controller admin login
     */
    Route::prefix('admin')->name('admin.')->controller(AdminLoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
    });

    /**
     * @prefix account
     */
    Route::prefix('account')->name('customer.')->group(function () {
        /**
         * @controller login
         */
        Route::controller(LoginController::class)->group(function () {
            Route::get('login', 'showLoginForm')->name('login');
            Route::post('login', 'login');
        });

        /**
         * @controller register
         */
        Route::controller(RegisterController::class)->group(function () {
            Route::get('register', 'showRegistrationForm')->name('register');
            Route::post('register', 'register');
        });

        /**
         * @controller forgot password
         */
        Route::name('password.')->controller(ForgotPasswordController::class)->group(function () {
            Route::get('password/reset', 'showLinkRequestForm')->name('request');
            Route::post('password/email', 'sendResetLinkEmail')->name('email');
        });

        /**
         * @controller reset password
         */
        Route::name('password.')->controller(ResetPasswordController::class)->group(function () {
            Route::get('password/reset/{token}', 'showResetForm')->name('reset');
            Route::post('password/reset', 'reset')->name('update');
        });
    });
});