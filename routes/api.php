<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\User\PasswordSetupController;
use App\Http\Controllers\User\UserController;
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
// Ping and healthcheck endpoints (useful for ALB health checking, etc)
Route::get('ping', [SystemController::class, 'ping'])->name('system.ping');
Route::get('healthcheck', [SystemController::class, 'healthCheck'])->name('system.healthcheck');

// Public routes that do not fall under authentication/authorization
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('setup-password/{id}/{hash}', [PasswordSetupController::class, 'setup'])->name('password.setup');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'currentUser'])->name('auth.user');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{user}', 'show');
        Route::post('', 'store');
        Route::put('{user}', 'update');
        Route::delete('{user}', 'destroy');
        Route::get('/form/data', 'form');
    });
});

