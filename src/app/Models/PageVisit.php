<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'ip', 'city', 'country', 'device',
        'user_agent', 'page_url', 'referrer', 'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
