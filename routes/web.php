<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::get('/users/stats', [UserController::class, 'stats'])->name('users.stats')->middleware('auth');
Route::resource('users', UserController::class)->middleware('auth');

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
