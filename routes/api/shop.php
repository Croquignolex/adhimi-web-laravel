<?php

use App\Http\Controllers\Api\V1\OrganisationController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Controllers\Api\V1\GroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
|
| Here is where you can register shop routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * @resource country
 */
Route::resource('countries', CountryController::class)->only('index');

/**
 * @resource state
 */
Route::resource('states', StateController::class)->only('index');

/**
 * @resource group
 */
Route::resource('groups', GroupController::class)->only('index');

/**
 * @controller organisations
 */
Route::controller(OrganisationController::class)->prefix('organisations')->name('organisations.')->group(function () {
    Route::get('{organisation}/shops', 'shops')->name('shops');
    Route::get('{organisation}/free-shops', 'freeShops')->name('shops.free');
});