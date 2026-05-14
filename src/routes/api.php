<?php

use App\Prices\PricesController;
use App\Stats\TrackController;
use Illuminate\Support\Facades\Route;

Route::get('/prices', [PricesController::class, 'index']);
Route::post('/track', [TrackController::class, 'store'])->middleware('throttle:60,1');
