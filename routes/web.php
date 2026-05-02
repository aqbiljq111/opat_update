<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Pastikan sudah dibuat
use App\Http\Controllers\ChatController;      // Pastikan sudah dibuat

// --- Guest Routes (Hanya bisa diakses kalau BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    // Admin/Guru Registration
    Route::get('/register-admin', [AuthController::class, 'showAdminRegister'])->name('register.admin');
    Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.post');
});

// --- Auth Routes (Hanya bisa diakses kalau SUDAH login) ---
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/reply', [ChatController::class, 'reply'])->name('chat.reply');
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');

    // Admin & Guru Routes (Atur Jadwal/Pengumuman)
    Route::middleware('can:atur-pengumuman')->group(function () {
        Route::post('/announcement', [DashboardController::class, 'storeAnnouncement'])->name('announcement.store');
        Route::put('/announcement/{id}', [DashboardController::class, 'updateAnnouncement'])->name('announcement.update');
        Route::delete('/announcement/{id}', [DashboardController::class, 'destroyAnnouncement'])->name('announcement.destroy');
    });

    // Admin Only Routes
    Route::middleware('can:admin')->group(function () {
        // Manajemen User
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}/role', [App\Http\Controllers\UserController::class, 'updateRole'])->name('users.updateRole');
    });
});