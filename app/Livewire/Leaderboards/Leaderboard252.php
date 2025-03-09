<?php

namespace App\Livewire\Leaderboards;

use App\Models\Score;
use Livewire\Component;

class Leaderboard252 extends Component
{

    public array $rankings = [];

    public array $rankingsRx = [];

    public array $rankingsScaled = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->rankings = Score::individualRankingOpenWod252()->toArray();
        $this->rankingsRx = Score::individualRankingOpenWod252('rx')->toArray();
        $this->rankingsScaled = Score::individualRankingOpenWod252('scaled')->toArray();
    }
}
