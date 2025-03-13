<?php

namespace App\Livewire\Leaderboards;

use App\Models\Score;
use Livewire\Component;

class Leaderboard253 extends Component
{

    public array $rankings = [];

    public array $rankingsRx = [];

    public array $rankingsScaled = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->rankings = Score::individualRankingOpenWod253()->toArray();
        $this->rankingsRx = Score::individualRankingOpenWod253('rx')->toArray();
        $this->rankingsScaled = Score::individualRankingOpenWod253('scaled')->toArray();
    }
}
