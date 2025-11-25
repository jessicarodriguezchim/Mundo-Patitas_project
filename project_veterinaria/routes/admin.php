<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;

// Dashboard - Solo admin y staff pueden acceder
Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin,staff');

// Gestión de roles - Solo admin
Route::middleware('role:admin')->group(function () {
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('users', UserController::class)->names('users');
});

// Gestión de mascotas - Admin y staff pueden gestionar
Route::middleware('role:admin,staff')->group(function () {
    Route::resource('pets', PetController::class)->names('pets');
});