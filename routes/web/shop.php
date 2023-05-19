<?php

use Illuminate\Support\Facades\Route;
use App\Http\Actions\TranslateAction;
use App\Http\Actions\HomeAction;

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
 * @get home
 */
Route::get('', HomeAction::class)->name('home');

/**
 * @get translate
 */
Route::get('translate/{language}', TranslateAction::class)->name('translate');
