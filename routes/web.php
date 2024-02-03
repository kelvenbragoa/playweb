<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', 'App\Http\Controllers\RoleController');
Route::resource('coins', 'App\Http\Controllers\CoinController');
Route::resource('courts', 'App\Http\Controllers\CourtController');
Route::resource('genders', 'App\Http\Controllers\GenderController');
Route::resource('players', 'App\Http\Controllers\PlayerController');
Route::resource('prices', 'App\Http\Controllers\PriceController');
Route::resource('prices', 'App\Http\Controllers\PriceController');
Route::resource('prices', 'App\Http\Controllers\PriceController');



//Ultima rota

Route::get('{view}', ApplicationController::class)->where('view','(.*)');