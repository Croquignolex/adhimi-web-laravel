<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register customer routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * @middleware auth customer
 */
Route::middleware('redirect:auth')->middleware('allow:customer')->prefix('account')->name('customer.')->group(function () {
    /**
     * @view home
     */
    Route::view('home', 'backoffice.customer.home')->name('home');
});