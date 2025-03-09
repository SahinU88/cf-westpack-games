<?php

namespace App\Traits;

use App\Models\Score;
use App\Models\Team;

trait HasRanking
{
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
                    'total_points' => $teamScores->sum('points')
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->all();
    }

    public static function teamRankingOpenWod252(): array
    {
        $rankingMapRx = self::individualRankingOpenWod252('rx');
        $rankingMapScaled = self::individualRankingOpenWod252('scaled');
        $allScores = $rankingMapRx->merge($rankingMapScaled);

        return Team::all()
            ->map(function ($team) use ($allScores) {
                $teamScores = $allScores->where('team.id', $team->id);
                $teamScoresRx = $teamScores->where('division', 'rx');
                $teamScoresScaled = $teamScores->where('division', 'scaled');

                return [
                    'team' => $team,
                    'wod' => '25.2',
                    'scores_rx' => [
                        'points' => $teamScoresRx->sum('points')
                    ],
                    'scores_scaled' => [
                        'points' => $teamScoresScaled->sum('points')
                    ],
                    'total_points' => $teamScores->sum('points')
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->all();
    }

    public static function individualRankingOpenWod251($division = false)
    {
        $rank = 0;
        $count = 0;
        $lastScore = null;

        return Score::with(['user', 'user.team'])
            ->rankingOpenWod251($division)
            ->get()
            ->map(function ($score, $key) use (&$rank, &$count, &$lastScore) {
                $count++;

                if ($lastScore !== $score->data['score']) {
                    $rank = $count;
                    $lastScore = $score->data['score'];
                }

                return [
                    'rank' => $rank,
                    'points' => $rank,
                    'team' => $score->user->team,
                    'user' => $score->user,
                    'score' => $score->data['score'],
                    'division' => $score->division
                ];
            });
    }

    public static function individualRankingOpenWod252($division = false)
    {
        // 1) Get all relevant scores for 25.2
        $scores =  Score::with(['user', 'user.team'])
            ->rankingOpenWod252($division)
            ->get();

        // 2) Sort using a custom callback
        $sortedScores = $scores
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

        $rank = 0;
        $count = 0;
        $lastKey = null;

        // 3) Optionally map to a final structure (assigning rank, etc.)
        return $sortedScores->map(function ($score, $index)  use (&$rank, &$count, &$lastKey) {
            $count++;

            $signature = static::finalResultKey($score);

            // If new signature, update rank to this athlete’s position in the list
            if ($signature !== $lastKey) {
                $rank = $count;
                $lastKey = $signature;
            }

            return [
                'rank' => $rank,
                'points' => $rank,
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

    protected static function finalResultKey($score): string
    {
        $finished = $score->data['finishedWod'] ?? false;

        if ($finished) {
            // For finishers: signature is e.g. "fin-315-42"
            $time = $score->data['time'] ?? 999999;
            $tiebreak = $score->data['tiebreak'] ?? 999999;
            return "fin-{$time}-{$tiebreak}";
        } else {
            // For non-finishers: signature is e.g. "nfin-122-24" (reps-tiebreak)
            $reps = $score->data['reps'] ?? 0;
            $tiebreak = $score->data['tiebreak'] ?? 999999;
            return "nfin-{$reps}-{$tiebreak}";
        }
    }
}
