<?php

namespace App\Traits;

use App\Models\Score;
use App\Models\Team;

trait HasRankingOpenWod254
{
    public static function teamRankingOpenWod254(): array
    {
        $rankingMapRx = self::individualRankingOpenWod254('rx');
        $rankingMapScaled = self::individualRankingOpenWod254('scaled');
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
                    'wod' => '25.4',
                    'scores_rx' => [
                        'points' => $teamScoresRx->sum('points')
                    ],
                    'scores_scaled' => [
                        'points' => $teamScoresScaled->sum('points')
                    ],
                    'total_points' => $team->users_count === 12 ?
                        $teamScores->sum('points') :
                        intval(round($teamScores->sum('points') / 12 * 11))
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->all();
    }

    public static function individualRankingOpenWod254($division = false)
    {
        $allScores = Score::with(['user', 'user.team'])
            ->rankingOpenWod254()
            ->get();

        $nonSubmissions = $allScores->filter(fn($score) => $score->data['reps'] == 0)->values();

        $rank = 0;
        $count = 0;
        $points = 0;
        $lastKey = null;

        // Start -- Rx
        $scoresRx = $allScores
            ->where('division', 'rx')
            ->filter(fn($score) => $score->data['reps'] > 0)
            ->values();
        $sortedScoresRx = self::sortScoresOpenWod254($scoresRx);
        $rankingsRx = self::createRanksOpenWod254($sortedScoresRx, $rank, $points, $count, $lastKey);
        // End -- Rx

        $lastRankRx = $rank + 1;
        $rank = 0;
        $lastKey = null;

        // Start -- Scaled
        $scoresScaled = $allScores
            ->where('division', 'scaled')
            ->filter(fn($score) => $score->data['reps'] > 0)
            ->values();
        $sortedScoresScaled = self::sortScoresOpenWod254($scoresScaled);
        $rankingsScaled = self::createRanksOpenWod254($sortedScoresScaled, $rank, $points, $count, $lastKey);
        // End -- Scaled

        $lastRankScaled = $rank + 1;
        $points++;

        $rankingsNonSubmissions = $nonSubmissions->map(function ($score) use (&$points, $lastRankRx, $lastRankScaled) {
            return [
                'rank' => $score->division === 'rx' ? $lastRankRx : $lastRankScaled,
                'points' => $points,
                'user' => $score->user,
                'team' => $score->user->team,
                'tiebreak' => $score->data['tiebreak'],
                'reps' => $score->data['reps'],
                'division' => $score->division,
            ];
        });

        $allRankings = $rankingsRx
            ->merge($rankingsScaled)
            ->merge($rankingsNonSubmissions);

        if ($division) {
            return $allRankings->where('division', $division);
        }

        $rank = 0;
        $lastKey = null;

        return $allRankings->map(function(array $rankArray, int $key) use (&$rank, &$lastKey) {
            $signature = static::finalResultKeyOpenWod254(
                $rankArray['tiebreak'],
                $rankArray['reps']
            );

            if ($lastKey !== $signature) {
                $rank = $key + 1;
                $lastKey = $signature;
            }

            return [
                ...$rankArray,
                'rank' => $rank,
            ];
        });
    }

    protected static function sortScoresOpenWod254($scores)
    {
        return $scores
            ->sort(function ($a, $b) {
                // Rule 1: reps
                $repsA = $a->data['reps'] ?? 0;
                $repsB = $b->data['reps'] ?? 0;

                if ($repsA !== $repsB) {
                    return $repsB <=> $repsA;
                }

                // Rule 2: if same reps, compare tie_break_time ascending
                $tiebreakA = $a->data['tiebreak'] ?? 999999;
                $tiebreakB = $b->data['tiebreak'] ?? 999999;
                return $tiebreakA <=> $tiebreakB;
            })
            ->values();
    }

    protected static function createRanksOpenWod254($sortedScores, &$rank, &$points, &$count, &$lastKey)
    {
        return $sortedScores->map(function ($score, $key)  use (&$rank, &$points, &$count, &$lastKey) {
            $count++;

            $signature = static::finalResultKeyOpenWod254(
                $score->data['tiebreak'],
                $score->data['reps']
            );

            // If new signature, update rank to this athlete’s position in the list
            if ($signature !== $lastKey) {
                $rank = $key + 1;
                $points = $count;
                $lastKey = $signature;
            }

            return [
                'rank' => $rank,
                'points' => $points,
                'user' => $score->user,
                'team' => $score->user->team,
                'tiebreak' => $score->data['tiebreak'],
                'reps' => $score->data['reps'],
                'division' => $score->division,
            ];
        });
    }

    protected static function finalResultKeyOpenWod254($tiebreak, $reps): string
    {
        return "{$reps}-{$tiebreak}";
    }
}
