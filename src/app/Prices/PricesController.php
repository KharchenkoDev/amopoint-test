<?php

namespace App\Prices;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PricesController
{
    public function index(Request $request): JsonResponse
    {
        $query = CoinPrice::orderBy('fetched_at', 'desc');

        if ($request->filled('coin_id')) {
            $query->where('coin_id', $request->coin_id);
        }

        $perPage = min($request->integer('per_page', 50), 500);

        return response()->json($query->paginate($perPage));
    }
}
