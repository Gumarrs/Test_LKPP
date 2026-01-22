<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LppbjController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. UBAH TAMPILAN AWAL: Langsung lempar ke halaman Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. MATIKAN REGISTER: Tambahkan ['register' => false]
// Ini membuat URL /register jadi 404 Not Found (Mati Total secara sistem)
Auth::routes(['register' => false]);

// Rute Dashboard
Route::get('/home', [DashboardController::class, 'index'])->name('home');

// Grup Auth
Route::middleware(['auth'])->group(function () {
    Route::get('lppbj/export', [LppbjController::class, 'export'])->name('lppbj.export');
    Route::resource('lppbj', LppbjController::class);

// Rute Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::resource('users', UserController::class);
});

Route::get('refresh-captcha', function () {
    return response()->json(['captcha' => captcha_img('flat')]);
})->name('refresh.captcha');