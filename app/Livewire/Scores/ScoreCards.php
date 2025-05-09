<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use App\Models\User;
use Livewire\Component;

class ScoreCards extends Component
{

    public Score $score251;

    public Score $score252;

    public Score $score253;

    public Score $score254;

    public array $rankingOpenWod251;

    public array $rankingOpenWod252;

    public array $rankingOpenWod253;

    public array $rankingOpenWod254;


    public function mount(): void
    {
        $user = auth()->user();

        $this->score251 = $this->getScoreFor251($user);
        $this->score252 = $this->getScoreFor252($user);
        $this->score253 = $this->getScoreFor253($user);
        $this->score254 = $this->getScoreFor254($user);

        $this->rankingOpenWod251 = Score::individualRankingOpenWod251($this->score251->division)
            ->where('user.id', $user->id)
            ->first();

        $this->rankingOpenWod252 = Score::individualRankingOpenWod252($this->score252->division)
            ->where('user.id', $user->id)
            ->first();

        $this->rankingOpenWod253 = Score::individualRankingOpenWod253($this->score253->division)
            ->where('user.id', $user->id)
            ->first();

        $this->rankingOpenWod254 = Score::individualRankingOpenWod254($this->score254->division)
            ->where('user.id', $user->id)
            ->first();
    }

    private function getScoreFor251(User $user): Score
    {
        $score = $user->scores()->openWod251()->first();

        if ($score === null)
        {
            $score = $user->scores()->create([
                'name' => 'Open WOD 25.1',
                'data' => [
                    'score' => 0,
                    'type' => 'reps',
                ],
                'division' => '',
            ]);
        }

        return $score;
    }

    private function getScoreFor252(User $user): Score
    {
        $score = $user->scores()->openWod252()->first();

        if ($score === null)
        {
            $score = $user->scores()->create([
                'name' => 'Open WOD 25.2',
                'data' => [
                    'finishedWod' => false,
                    'reps' => 0,
                    'time' => '00:00',
                    'tiebreak' => '00:00',
                    'type' => 'time-or-reps',
                ],
                'division' => '',
            ]);
        }

        return $score;
    }

    private function getScoreFor253(User $user): Score
    {
        $score = $user->scores()->openWod253()->first();

        if ($score === null)
        {
            $score = $user->scores()->create([
                'name' => 'Open WOD 25.3',
                'data' => [
                    'finishedWod' => false,
                    'reps' => 0,
                    'time' => '00:00',
                    'tiebreak' => '00:00',
                    'type' => 'time-or-reps',
                ],
                'division' => '',
            ]);
        }

        return $score;
    }

    private function getScoreFor254(User $user): Score
    {
        $score = $user->scores()->openWod254()->first();

        if ($score === null)
        {
            $score = $user->scores()->create([
                'name' => 'Bonus WOD 25.4',
                'data' => [
                    'reps' => 0,
                    'tiebreak' => '00:00',
                    'type' => 'reps-with-tiebreak',
                ],
                'division' => '',
            ]);
        }

        return $score;
    }
}
