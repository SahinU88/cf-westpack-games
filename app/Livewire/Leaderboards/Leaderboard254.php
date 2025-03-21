<?php

namespace App\Livewire\Leaderboards;

use App\Models\Score;
use Livewire\Component;

class Leaderboard254 extends Component
{

    public array $rankings = [];

    public array $rankingsRx = [];

    public array $rankingsScaled = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->rankings = Score::individualRankingOpenWod254()->toArray();
        $this->rankingsRx = Score::individualRankingOpenWod254('rx')->toArray();
        $this->rankingsScaled = Score::individualRankingOpenWod254('scaled')->toArray();
    }
}
