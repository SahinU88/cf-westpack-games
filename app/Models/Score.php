<?php

namespace App\Models;

use App\Traits\HasRanking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    use HasRanking;

    protected $casts = [
        'data' => 'array',
    ];

    public function scopeRankingOpenWod251($query, $division = false)
    {
        return $query
            ->where('name', 'Open WOD 25.1')
            ->when($division, fn($query) => $query->where('division', $division))
            ->orderBy('data->score', 'desc');
    }

    public function scopeRankingOpenWod252($query, $division = false)
    {
        return $query
            ->where('name', 'Open WOD 25.2')
            ->when($division, fn($query) => $query->where('division', $division));
    }

    public function scopeRankingOpenWod253($query, $division = false)
    {
        return $query
            ->where('name', 'Open WOD 25.3')
            ->when($division, fn($query) => $query->where('division', $division));
    }

    public function scopeOpenWod251($query)
    {
        return $query->where('name', 'Open WOD 25.1');
    }

    public function scopeOpenWod252($query)
    {
        return $query->where('name', 'Open WOD 25.2');
    }

    public function scopeOpenWod253($query)
    {
        return $query->where('name', 'Open WOD 25.3');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
