<?php

use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;

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
    Route::get('auth/logout', 'logout')->middleware('auth:api')->name('logout');
});

Route::controller(TokenController::class)->group(function () {
    Route::get('auth/autenticado', 'verificar_token');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'buscar')->middleware('auth:api')->name('buscar');
    Route::get('/usuarios/{id}', 'buscar_id')->middleware('auth:api')->name('buscar_id');
    Route::post('/usuarios', 'registrar')->name('registrar');
    Route::put('/usuarios/{id}', 'modificar')->middleware('auth:api')->name('modificar');
    Route::delete('/usuarios/{id}', 'eliminar')->middleware('auth:api')->name('eliminar');
});

Route::controller(PasswordController::class)->group(function () {
    Route::post('/password', 'generar_token');
    Route::get('/password/{token}', 'comprobar_token');
    Route::put('/password', 'modificar');
});
