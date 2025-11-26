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

// Public search endpoint
Route::get('/creators/search', [App\Http\Controllers\TalentsController::class, 'search']);

// Favorite routes for authenticated users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/favorites/{creatorProfileId}', [App\Http\Controllers\FavoriteController::class, 'toggle']);
    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index']);
});
