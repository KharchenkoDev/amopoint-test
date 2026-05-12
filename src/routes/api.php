<?php

use App\Http\Controllers\TrackController;
use App\Models\CoinPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/prices', function (Request $request) {
    $query = CoinPrice::orderBy('fetched_at', 'desc');

    if ($request->filled('coin_id')) {
        $query->where('coin_id', $request->coin_id);
    }

    $perPage = min($request->integer('per_page', 50), 500);

    return response()->json($query->paginate($perPage));
});

Route::post('/track', [TrackController::class, 'store']);
