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


|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/loginuser',[\App\Http\Controllers\AuthController::class,'loginuser']);
Route::post('/login',[\App\Http\Controllers\AuthController::class,'loginuserweb']);
Route::post('/registeruser',[\App\Http\Controllers\AuthController::class,'registeruser']);

Route::resource('roles', 'App\Http\Controllers\RoleController');
Route::resource('coins', 'App\Http\Controllers\CoinController');
Route::resource('courts', 'App\Http\Controllers\CourtController');
Route::resource('clubs', 'App\Http\Controllers\ClubsController');
Route::resource('genders', 'App\Http\Controllers\GenderController');
Route::resource('players', 'App\Http\Controllers\PlayerController');
Route::resource('status', 'App\Http\Controllers\StatusController');
Route::resource('schedules', 'App\Http\Controllers\ScheduleController');
Route::resource('prices', 'App\Http\Controllers\PriceController');

Route::resource('getcourts', 'App\Http\Controllers\Api\CourtsController');
Route::resource('getclubs', 'App\Http\Controllers\Api\ClubsController');
Route::resource('getschedules', 'App\Http\Controllers\Api\ScheduleController');
Route::resource('player', 'App\Http\Controllers\Api\PlayerController');

Route::resource('wallet', 'App\Http\Controllers\Api\WalletController');

Route::post('/wallet/mpesa',[\App\Http\Controllers\Api\WalletController::class,'mpesa']);
Route::post('/wallet/emola',[\App\Http\Controllers\Api\WalletController::class,'emola']);
Route::post('/wallet/visa',[\App\Http\Controllers\Api\WalletController::class,'visa']);

Route::get('/transaction/{id}',[\App\Http\Controllers\Api\WalletController::class,'transaction']);

Route::get('/myschedule/{id}',[\App\Http\Controllers\Api\PlayerController::class,'myschedule']);

Route::get('/getschedules/{id}/{userid}',[\App\Http\Controllers\Api\ScheduleController::class,'showschedule']);

Route::get('/notification/{id}',[\App\Http\Controllers\Api\Notification::class,'index']);