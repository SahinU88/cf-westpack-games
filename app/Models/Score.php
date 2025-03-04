<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{

    protected $casts = [
        'data' => 'array',
    ];

    public function scopeOpenWod25_1($query)
    {
        return $query->where('name', 'Open WOD 25.1');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
