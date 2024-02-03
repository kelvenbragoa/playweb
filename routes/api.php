<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/loginuser',[\App\Http\Controllers\AuthController::class,'loginuser']);
Route::post('/registeruser',[\App\Http\Controllers\AuthController::class,'registeruser']);

Route::resource('roles', 'App\Http\Controllers\RoleController');
Route::resource('coins', 'App\Http\Controllers\CoinController');
Route::resource('courts', 'App\Http\Controllers\CourtController');
Route::resource('genders', 'App\Http\Controllers\GenderController');
Route::resource('players', 'App\Http\Controllers\PlayerController');
Route::resource('status', 'App\Http\Controllers\StatusController');
Route::resource('schedules', 'App\Http\Controllers\ScheduleController');
Route::resource('prices', 'App\Http\Controllers\PriceController');

Route::resource('getcourts', 'App\Http\Controllers\Api\CourtsController');
Route::resource('getschedules', 'App\Http\Controllers\Api\ScheduleController');
Route::resource('player', 'App\Http\Controllers\Api\PlayerController');

Route::get('/myschedule/{id}',[\App\Http\Controllers\Api\PlayerController::class,'myschedule']);
