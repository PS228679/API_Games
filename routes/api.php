<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\GameController;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::apiResource('developers', DeveloperController::class)
               ->only(['index', 'show']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', function (Request $request) { 
        return auth()->user(); 
    });

    Route::apiResource('games', GameController::class);
    Route::get('developer/{id}/games', [GameController::class, 'indexDeveloper']);
    Route::delete('developer/{id}/games', [GameController::class, 'destroyDeveloper']);


    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com '], 404);
});
