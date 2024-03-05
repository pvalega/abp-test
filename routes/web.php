<?php

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/info-city', App\Http\Controllers\CityController::class);

Route::get('/get-state/{countryId}', [App\Http\Controllers\CityController::class, 'getState']);

Route::get('/get-city/{countryId}/{stateId}', [App\Http\Controllers\CityController::class, 'getCity']);

Route::get('/getinfo-city/{city}/{country}', [App\Http\Controllers\CityController::class, 'infoCity']);

//Route::post('/info-city', [App\Http\Controllers\CityController::class, 'store']);

Route::get('/mis-ciudades', [App\Http\Controllers\CityController::class, 'ciudades']);

//Route::delete('/info-city/{cityId]', [App\Http\Controllers\CityController::class, 'delete']);




