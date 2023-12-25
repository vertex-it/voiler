<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\APIAuthController;

Route::middleware(['api'])->prefix('api')->group(function() {
    Route::post('login', [APIAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [APIAuthController::class, 'logout']);
        Route::get('user', [APIAuthController::class, 'user']);
    });
});
