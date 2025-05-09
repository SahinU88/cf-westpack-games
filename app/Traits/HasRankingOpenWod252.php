<?php

namespace App\Traits;

use App\Models\Score;
use App\Models\Team;

trait HasRankingOpenWod252
{
    public static function teamRankingOpenWod252(): array
    {
        $rankingMapRx = self::individualRankingOpenWod252('rx');
        $rankingMapScaled = self::individualRankingOpenWod252('scaled');
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
                    'wod' => '25.2',
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

    public static function individualRankingOpenWod252($division = false)
    {
        $allScores = Score::with(['user', 'user.team'])
            ->rankingOpenWod252()
            ->get();

        $nonSubmissions = $allScores->filter(fn($score) => $score->data['finishedWod'] === false && $score->data['reps'] == 0)->values();

        $rank = 0;
        $count = 0;
        $points = 0;
        $lastKey = null;

        // Start -- Rx
        $scoresRx = $allScores
            ->where('division', 'rx')
            ->filter(fn($score) => $score->data['finishedWod'] === true || $score->data['reps'] > 0)
            ->values();
        $sortedScoresRx = self::sortScoresOpenWod252($scoresRx);
        $rankingsRx = self::createRanksOpenWod252($sortedScoresRx, $rank, $points, $count, $lastKey);
        // End -- Rx

        $lastRankRx = $rank + 1;
        $rank = 0;
        $lastKey = null;

        // Start -- Scaled
        $scoresScaled = $allScores
            ->where('division', 'scaled')
            ->filter(fn($score) => $score->data['finishedWod'] === true || $score->data['reps'] > 0)
            ->values();
        $sortedScoresScaled = self::sortScoresOpenWod252($scoresScaled);
        $rankingsScaled = self::createRanksOpenWod252($sortedScoresScaled, $rank, $points, $count, $lastKey);
        // End -- Scaled

        $lastRankScaled = $rank + 1;
        $points++;

        $rankingsNonSubmissions = $nonSubmissions->map(function ($score) use (&$points, $lastRankRx, $lastRankScaled) {
            return [
                'rank' => $score->division === 'rx' ? $lastRankRx : $lastRankScaled,
                'points' => $points,
                'user' => $score->user,
                'team' => $score->user->team,
                'finishedWod' => $score->data['finishedWod'],
                'time' => $score->data['time'],
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
            $signature = static::finalResultKeyOpenWod252(
                $rankArray['finishedWod'],
                $rankArray['time'],
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

    protected static function sortScoresOpenWod252($scores)
    {
        return $scores
            ->sort(function ($a, $b) {
                $aFinished = $a->data['finishedWod'] ?? false;
                $bFinished = $b->data['finishedWod'] ?? false;

                // Rule 1: Finished > not finished
                if ($aFinished && !$bFinished) {
                    return -1; // $a goes before $b
                }
                if (!$aFinished && $bFinished) {
                    return 1; // $b goes before $a
                }

                // If both finished:
                if ($aFinished && $bFinished) {
                    // Rule 2: order by finish_time ascending
                    $timeA = $a->data['time'] ?? 999999;
                    $timeB = $b->data['time'] ?? 999999;
                    if ($timeA !== $timeB) {
                        return $timeA <=> $timeB;
                    }

                    // Rule 3: if same finish_time, compare tie_break_time ascending
                    $tiebreakA = $a->data['tiebreak'] ?? 999999;
                    $tiebreakB = $b->data['tiebreak'] ?? 999999;
                    return $tiebreakA <=> $tiebreakB;
                }

                // If neither finished:
                $repsA = $a->data['reps'] ?? 0;
                $repsB = $b->data['reps'] ?? 0;
                if ($repsA !== $repsB) {
                    // Rule 4: higher reps => better rank (so sort descending)
                    return $repsB <=> $repsA;
                }

                // Rule 5: if same reps, compare tie_break_time ascending
                $tiebreakA = $a->data['tiebreak'] ?? 999999;
                $tiebreakB = $b->data['tiebreak'] ?? 999999;
                return $tiebreakA <=> $tiebreakB;
            })
            ->values();
    }

    protected static function createRanksOpenWod252($sortedScores, &$rank, &$points, &$count, &$lastKey)
    {
        return $sortedScores->map(function ($score, $key)  use (&$rank, &$points, &$count, &$lastKey) {
            $count++;

            $signature = static::finalResultKeyOpenWod252(
                $score->data['finishedWod'],
                $score->data['time'],
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
                'finishedWod' => $score->data['finishedWod'],
                'time' => $score->data['time'],
                'tiebreak' => $score->data['tiebreak'],
                'reps' => $score->data['reps'],
                'division' => $score->division,
            ];
        });
    }

    protected static function finalResultKeyOpenWod252($finishedWod, $time, $tiebreak, $reps): string
    {
        if ($finishedWod) {
            // For finishers: signature is e.g. "fin-315-42"
            $time ??= 999999;
            $tiebreak ??= 999999;

            return "fin-{$time}-{$tiebreak}";
        } else {
            // For non-finishers: signature is e.g. "nfin-122-24" (reps-tiebreak)
            $reps ??= 0;
            $tiebreak ??= 999999;

            return "nfin-{$reps}-{$tiebreak}";
        }
    }
}
