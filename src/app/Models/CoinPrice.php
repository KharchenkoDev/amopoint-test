<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPrice extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'coin_id',
        'price_usd',
        'fetched_at',
        'created_at',
    ];

    protected $casts = [
        'price_usd' => 'float',
        'fetched_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
