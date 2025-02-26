<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);


// Protecting Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::post('/save-presensi', [App\Http\Controllers\API\PresensiController::class, 'savePresensi']);
    Route::get('/get-presensi', [App\Http\Controllers\API\PresensiController::class, 'getPresensis']);
    Route::get('/get-presensi-hari-ini', [App\Http\Controllers\API\PresensiController::class, 'getPresensisHariIni']);
    Route::post('/save-izin', [App\Http\Controllers\Api\IzinController::class, 'saveIzin']);
    Route::get('/get-izin', [App\Http\Controllers\API\IzinController::class, 'getIzin']);
    Route::get('/get-izin-hari-ini', [App\Http\Controllers\API\IzinController::class, 'getIzinHariIni']);
});