<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{slug}', [ArticleController::class, 'show']);
    Route::get('/search', [ArticleController::class, 'search']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/articles/p/personalized', [ArticleController::class, 'personalizedFeed']);

    Route::post('/preferences', [UserPreferenceController::class, 'store']);
    Route::get('/preferences', [UserPreferenceController::class, 'show']);
    Route::put('/preferences', [UserPreferenceController::class, 'update']);
});
