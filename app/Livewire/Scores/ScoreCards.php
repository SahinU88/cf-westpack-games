<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Livewire\Component;

class ScoreCards extends Component
{

    public Score $score251;

    public Score $score252;

    public array $rankingOpenWod251;

    public array $rankingOpenWod252;


    public function mount(): void
    {
        $user = auth()->user();

        $this->score251 = $user->scores()->openWod251()->first();

        if ($user->scores()->openWod252()->exists()){
            $this->score252 = $user->scores()->openWod252()->first();
        } else {
            $this->score252 = $user->scores()->create([
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

        $this->rankingOpenWod251 = Score::individualRankingOpenWod251($this->score251->division)
            ->where('user.id', $user->id)
            ->first();
    }
}
