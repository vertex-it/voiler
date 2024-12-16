<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\ActivityController;
use VertexIT\Voiler\Http\Controllers\PermissionController;
use VertexIT\Voiler\Http\Controllers\ProfileController;
use VertexIT\Voiler\Http\Controllers\RoleController;
use VertexIT\Voiler\Http\Controllers\UserController;
use VertexIT\Voiler\Http\Controllers\VoilerUploadController;

Route::prefix('voiler/upload')->group(function() {
    Route::post('file', [VoilerUploadController::class, 'file'])->name('voiler.file');
    Route::post('image', [VoilerUploadController::class, 'image'])->name('voiler.image');
});

Route::middleware(config('voiler.middleware'))->group(function() {
    $dashboardController = VertexIT\Voiler\Http\Controllers\DashboardController::class;

    if (class_exists('App\Http\Controllers\Admin\DashboardController')) {
        $dashboardController = App\Http\Controllers\Admin\DashboardController::class;
    }

    Route::get('/', [$dashboardController, 'index'])->name('admin.index');
});

Route::voilerResource('activities', ActivityController::class);
Route::voilerResource('roles', RoleController::class);
Route::voilerResource('permissions', PermissionController::class);
Route::voilerResource('users', UserController::class);
Route::voilerResource('profiles', ProfileController::class);
