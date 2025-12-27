<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortalController;

Route::get('/', fn() => redirect('/portal'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/portal', [PortalController::class, 'index'])->middleware('auth')->name('portal');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
