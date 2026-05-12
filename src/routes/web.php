<?php

use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/stats/login', [StatsController::class, 'showLogin'])->name('stats.login');
Route::post('/stats/login', [StatsController::class, 'login'])->name('stats.login.submit');
Route::post('/stats/logout', [StatsController::class, 'logout'])->name('stats.logout');
Route::get('/stats', [StatsController::class, 'dashboard'])->name('stats.dashboard');
