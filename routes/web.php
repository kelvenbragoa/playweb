<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Auth;

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



Route::get('/auxiliar-create-schedule', [App\Http\Controllers\GlobalController::class, 'auxiliardataschedules']);
Route::get('/home-data', [App\Http\Controllers\GlobalController::class, 'home']);
// Route::resource('roles', 'App\Http\Controllers\RoleController');
// Route::resource('coins', 'App\Http\Controllers\CoinController');
// Route::resource('courts', 'App\Http\Controllers\CourtController');
// Route::resource('genders', 'App\Http\Controllers\GenderController');
// Route::resource('players', 'App\Http\Controllers\PlayerController');
// Route::resource('prices', 'App\Http\Controllers\PriceController');
// Route::resource('prices', 'App\Http\Controllers\PriceController');
// Route::resource('prices', 'App\Http\Controllers\PriceController');

Route::resource('users', 'App\Http\Controllers\Admin\UsersController');
Route::resource('courts', 'App\Http\Controllers\Admin\CourtsController');
Route::resource('schedules', 'App\Http\Controllers\Admin\SchedulesController');



Route::get('/admins/dashboard/getdashboarddata', [App\Http\Controllers\Admin\DashboardDataController::class, 'index']);



//Ultima rota

Route::get('{view}', ApplicationController::class)->where('view','(.*)');