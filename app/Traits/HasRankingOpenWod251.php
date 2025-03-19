<?php

namespace App\Traits;

use App\Models\Score;
use App\Models\Team;

trait HasRankingOpenWod251
{
    public static function teamRankingOpenWod251(): array
    {
        $rankingMapRx = self::individualRankingOpenWod251('rx');
        $rankingMapScaled = self::individualRankingOpenWod251('scaled');
        $allScores = $rankingMapRx->merge($rankingMapScaled);

        return Team::withCount('users')
            ->get()
            ->map(function ($team) use ($allScores) {
                $teamScores = $allScores->where('team.id', $team->id);
                $teamScoresRx = $teamScores->where('division', 'rx');
                $teamScoresScaled = $teamScores->where('division', 'scaled');

                // reject worst score pro team
                $teamScoresScaled = $teamScoresScaled->sortBy('points')->values()->slice(0, $teamScoresScaled->count() - 1);

                return [
                    'team' => $team,
                    'wod' => '25.1',
                    'scores_rx' => [
                        'score' => $teamScoresRx->sum('score'),
                        'points' => $teamScoresRx->sum('points')
                    ],
                    'scores_scaled' => [
                        'score' => $teamScoresScaled->sum('score'),
                        'points' => $teamScoresScaled->sum('points')
                    ],
                    'total_score' => $teamScores->sum('score'),
                    'total_points' => $team->users_count === 12 ?
                        $teamScores->sum('points') :
                        intval(round($teamScores->sum('points') / 12 * 11))
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->all();
    }

    public static function individualRankingOpenWod251($division = false)
    {
        $rank = 0;
        $points = 0;
        $count = 0;
        $lastScore = null;

        $allScores = Score::with(['user', 'user.team'])->rankingOpenWod251()->get();
        $nonSubmissions = $allScores->where('data.score', 0)->values();

        $rankingsRx = $allScores
            ->where('division', 'rx')
            ->where('data.score', '>', 0)
            ->values()
            ->map(function (Score $score, int $key) use (&$rank, &$points, &$count, &$lastScore) {
                $count++;

                if ($lastScore !== $score->data['score']) {
                    $rank = $key + 1;
                    $points = $count;
                    $lastScore = $score->data['score'];
                }

                return [
                    'rank' => $rank,
                    'points' => $points,
                    'team' => $score->user->team,
                    'user' => $score->user,
                    'score' => $score->data['score'],
                    'division' => $score->division
                ];
            });

        $lastRankRx = $rank + 1;
        $rank = 0;
        $lastScore = null;

        $rankingsScaled = $allScores
            ->where('division', 'scaled')
            ->where('data.score', '>', 0)
            ->values()
            ->map(function (Score $score, int $key) use (&$rank, &$points, &$count, &$lastScore) {
                $count++;

                if ($lastScore !== $score->data['score']) {
                    $rank = $key + 1;
                    $points = $count;
                    $lastScore = $score->data['score'];
                }

                return [
                    'rank' => $rank,
                    'points' => $points,
                    'team' => $score->user->team,
                    'user' => $score->user,
                    'score' => $score->data['score'],
                    'division' => $score->division
                ];
            });

        $lastRankScaled = $rank + 1;
        $points++;

        $rankingsNonSubmissions = $nonSubmissions
            ->map(function (Score $score, int $key) use (&$lastRankRx, &$lastRankScaled, &$points) {
                return [
                    'rank' => $score->division === 'rx' ? $lastRankRx : $lastRankScaled,
                    'points' => $points,
                    'team' => $score->user->team,
                    'user' => $score->user,
                    'score' => $score->data['score'],
                    'division' => $score->division
                ];
            });

        $allRankings = $rankingsRx
            ->merge($rankingsScaled)
            ->merge($rankingsNonSubmissions);

        if ($division) {
            return $allRankings->where('division', $division);
        }

        $rank = 0;
        $lastScore = null;

        return $allRankings->map(function(array $rankArray, int $key) use (&$rank, &$lastScore) {

            if ($lastScore !== $rankArray['score']) {
                $rank = $key + 1;
                $lastScore = $rankArray['score'];
            }

            return [
                ...$rankArray,
                'rank' => $rank,
            ];
        });
    }
}
