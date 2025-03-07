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
        $this->score252 = $user->scores()->openWod252()->first();

        $this->rankingOpenWod251 = Score::individualRankingOpenWod251($this->score251->division)
            ->where('user.id', $user->id)
            ->first();
    }
}
