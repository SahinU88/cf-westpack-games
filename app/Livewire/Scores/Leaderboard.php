<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Livewire\Component;

class Leaderboard extends Component
{

    public array $rankingOpenWod251;


    public function mount(): void
    {
        $this->rankingOpenWod251 = Score::teamRankingOpenWod251();
    }
}
