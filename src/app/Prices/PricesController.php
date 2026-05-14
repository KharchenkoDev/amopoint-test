<?php

namespace App\Prices;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PricesController
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'coin_id'  => ['sometimes', 'string', Rule::in(config('services.coingecko.coins'))],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:500'],
            'page'     => ['sometimes', 'integer', 'min:1'],
        ]);

        $query = CoinPrice::orderBy('fetched_at', 'desc');

        if (isset($validated['coin_id'])) {
            $query->where('coin_id', $validated['coin_id']);
        }

        return response()->json($query->paginate($validated['per_page'] ?? 50));
    }
}
