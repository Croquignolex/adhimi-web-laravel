<?php

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
    });
});