<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Livewire\Component;

class ScoreCards extends Component
{

    public Score $score;

    public array $rankingOpenWod251;


    public function mount(): void
    {
        $user = auth()->user();

        $this->score = $user->scores()->openWod251()->first();

        $this->rankingOpenWod251 = Score::individualRankingOpenWod251($this->score->division)
            ->where('user.id', $user->id)
            ->first();
    }
}
