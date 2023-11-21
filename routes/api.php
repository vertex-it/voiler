<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\APIAuthController;

Route::middleware('api')->prefix('api')->group(function() {
    Route::post('tokens/create', [APIAuthController::class, 'createToken']);
});

