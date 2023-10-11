<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login')->name('login');
    Route::get('auth/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'buscar')->middleware('auth:sanctum')->name('buscar');
    Route::get('/usuarios/{id}', 'buscar_id')->middleware('auth:sanctum')->name('buscar_id');
    Route::post('/usuarios/registrar', 'registrar')->name('registrar');
    Route::put('/usuarios/actualizar/{id}', 'actualizar')->middleware('auth:sanctum')->name('actualizar');
    Route::delete('/usuarios/eliminar/{id}', 'eliminar')->middleware('auth:sanctum')->name('eliminar');
});
