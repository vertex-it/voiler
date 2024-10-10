<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\APIAuthController;
use VertexIT\Voiler\Http\Controllers\VoilerFileController;

Route::middleware(['api'])->prefix('api')->group(function() {
    Route::post('voiler/files', [VoilerFileController::class, 'store']);

    Route::post('login', [APIAuthController::class, 'login']);
    Route::post('register', [APIAuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [APIAuthController::class, 'logout']);
        Route::get('user', [APIAuthController::class, 'user']);
    });
});
