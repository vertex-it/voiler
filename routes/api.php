<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\APIAuthController;
use VertexIT\Voiler\Http\Controllers\VoilerUploadController;

Route::middleware(['api'])->prefix('api')->group(function() {
    Route::prefix('voiler/upload')->group(function() {
        Route::post('file', [VoilerUploadController::class, 'file']);
        Route::post('image', [VoilerUploadController::class, 'image']);
    });

    Route::post('login', [APIAuthController::class, 'login']);
    Route::post('register', [APIAuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [APIAuthController::class, 'logout']);
        Route::get('user', [APIAuthController::class, 'user']);
    });
});
