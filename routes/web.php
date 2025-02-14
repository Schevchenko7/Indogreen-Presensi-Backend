<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IzinController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/create-user', [UserController::class, 'create'])->name('create-user');
Route::post('/store-user', [UserController::class, 'store'])->name('user-store');

// Route untuk reset password
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/password/reset/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Menambahkan middleware auth untuk route izin
Route::middleware(['auth'])->group(function () {
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('/create-izin', [IzinController::class, 'create'])->name('izin.create');
    Route::post('/store-izin', [IzinController::class, 'store'])->name('izin.store');
});
