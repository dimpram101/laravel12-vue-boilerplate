<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('settings', function () {
        return Inertia::render('settings/Profile');
    })->name('settings');

    Route::prefix('admin')->middleware(['role:admin|super-admin'])->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('admin.users');

        Route::resource('roles', RoleController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'show' => 'admin.roles.show',
        ]);

        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'admin.permissions.index',
        ]);
    });
});

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
