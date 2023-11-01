<?php

use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Http\Controllers\ActivityController;
use VertexIT\Voiler\Http\Controllers\DashboardController;
use VertexIT\Voiler\Http\Controllers\PermissionController;
use VertexIT\Voiler\Http\Controllers\ProfileController;
use VertexIT\Voiler\Http\Controllers\RoleController;
use VertexIT\Voiler\Http\Controllers\UserController;

Route::middleware(config('voiler.middleware'))->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

    Route::get('activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
});

Route::voilerResource('activities', ActivityController::class);
Route::voilerResource('roles', RoleController::class);
Route::voilerResource('permissions', PermissionController::class);
Route::voilerResource('users', UserController::class);
Route::voilerResource('profiles', ProfileController::class);
