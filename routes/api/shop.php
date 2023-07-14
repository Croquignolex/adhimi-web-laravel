<?php

use App\Http\Controllers\Api\V1\OrganisationController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\ShopController;
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
 * @resource countries
 */
Route::resource('countries', CountryController::class)->only('index');

/**
 * @resource states
 */
Route::resource('states', StateController::class)->only('index');

/**
 * @resource groups
 */
Route::resource('groups', GroupController::class)->only('index');

/**
 * @resource shops
 */
Route::resource('shops', ShopController::class)->only('index');

/**
 * @resource organisations
 * @controller organisations
 */
Route::resource('organisations', OrganisationController::class)->only('index');
Route::controller(OrganisationController::class)->prefix('organisations')->name('organisations.')->group(function () {
    Route::get('{organisation}/shops', 'shops')->name('shops');
});