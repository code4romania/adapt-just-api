<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Public\ArticlePublicController;
use App\Http\Controllers\Public\ResourcePublicController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UploadController;
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

Route::post('uploads', [UploadController::class, 'store'])->name('uploads.store');
Route::get('uploads/{uploadHashName}', [UploadController::class, 'show'])->name('uploads.show');


Route::prefix('complaints')->name('complaints.')->controller(ComplaintController::class)->group(function () {
    Route::post('', 'store');
});

Route::prefix('public')->name('public.')->group(function () {
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::prefix('articles')->name('articles.')->controller(ArticlePublicController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{article}', 'show');
    });
    Route::prefix('resources')->name('resources.')->controller(ResourcePublicController::class)->group(function () {
        Route::get('{type}', 'index');
        Route::get('{resource}/show', 'show');
    });

    Route::prefix('complaints')->name('complaints.')->controller(ComplaintController::class)-> group(function () {
        Route::get('institutions/list', 'institutions');
    });
});


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

    Route::prefix('complaints')->name('complaints.')->controller(ComplaintController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{complaint}', 'show');
        Route::put('{complaint}', 'update');
    });

    Route::prefix('articles')->name('articles.')->controller(ArticleController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{article}', 'show');
        Route::post('', 'store');
        Route::put('{article}', 'update');
        Route::delete('{article}', 'destroy');
    });

    Route::prefix('resources')->name('resources.')->controller(ResourceController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{resource}', 'show');
        Route::post('', 'store');
        Route::put('{resource}', 'update');
        Route::delete('{resource}', 'destroy');
    });

});

