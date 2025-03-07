<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatController;
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
Route::middleware('auth:sanctum')->group(function () {
    Route::get("/stats", [UserStatController::class, "stats"])->name("stats");
    Route::post("/stats_create", [UserStatController::class, "create"])->name("stats_create");
    Route::get('/user', [UserController::class, 'getUser']);
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

