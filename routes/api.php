<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'api', 'auth:api', ['except' => ['login', 'register']]], function ($router) {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);//->middleware(['auth', 'verified']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::post('/profile', [UserController::class, 'profile']);
});

Route::get('/send', [UserController::class, 'sendMail']);
Route::get('/verify', [UserController::class, 'verification']);

Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verification'])->middleware(['auth', 'signed'])->name('verification.verify');




