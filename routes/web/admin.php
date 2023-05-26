<?php

use App\Http\Controllers\Backoffice\Admin\ProfileController;
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
            Route::get('general', 'infoShowForm')->name('general');
            Route::put('general', 'infoUpdate');
            Route::get('settings', 'settingsShowForm')->name('settings');
            Route::put('settings', 'settingsUpdate');
            Route::view('password', 'backoffice.admin.profile.password')->name('password');
            Route::put('password', 'passwordUpdate');
            Route::get('logs', 'logsShowForm')->name('logs');
//            Route::get('avatar', 'avatarShowForm')->name('avatar');
//            Route::put('avatar', 'avatarUpdate');
//            Route::delete('avatar', 'avatarUpdate');
        });
    });
});