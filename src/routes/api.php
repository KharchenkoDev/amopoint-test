<?php

use App\Models\CoinPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/prices', function (Request $request) {
    $query = CoinPrice::orderBy('fetched_at', 'desc');

    if ($request->filled('coin_id')) {
        $query->where('coin_id', $request->coin_id);
    }

    if ($request->filled('per_page')) {
        return response()->json($query->paginate((int) $request->per_page));
    }

    return response()->json($query->get());
});
