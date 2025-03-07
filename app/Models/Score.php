<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $casts = [
        'data' => 'array',
    ];

    public static function teamRankingOpenWod251(): array
    {
        $rankingMapRx = self::individualRankingOpenWod251('rx');
        $rankingMapScaled = self::individualRankingOpenWod251('scaled');
        $allScores = $rankingMapRx->merge($rankingMapScaled);

        return Team::all()
            ->map(function ($team) use ($allScores) {
                $teamScores = $allScores->where('team.id', $team->id);
                $teamScoresRx = $teamScores->where('division', 'rx');
                $teamScoresScaled = $teamScores->where('division', 'scaled');

                return [
                    'team' => $team,
                    'scores_rx' => [
                        'score' => $teamScoresRx->sum('score'),
                        'points' => $teamScoresRx->sum('points')
                    ],
                    'scores_scaled' => [
                        'score' => $teamScoresScaled->sum('score'),
                        'points' => $teamScoresScaled->sum('points')
                    ],
                    'total_score' => $teamScores->sum('score'),
                    'total_points' => $teamScores->sum('points')
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->all();
    }

    public static function individualRankingOpenWod251($division = false)
    {
        return Score::with(['user', 'user.team'])
            ->rankingOpenWod251($division)
            ->get()
            ->map(function ($score, $key) {
                return [
                    'points' => $key + 1,
                    'team' => $score->user->team,
                    'user' => $score->user,
                    'score' => $score->data['score'],
                    'division' => $score->division
                ];
            });
    }

    public function scopeRankingOpenWod251($query, $division = false)
    {
        return $query
            ->where('name', 'Open WOD 25.1')
            ->when($division, fn($query) => $query->where('division', $division))
            ->orderBy('data->score', 'desc');
    }

    public function scopeOpenWod251($query)
    {
        return $query->where('name', 'Open WOD 25.1');
    }

    public function scopeOpenWod252($query)
    {
        return $query->where('name', 'Open WOD 25.2');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
