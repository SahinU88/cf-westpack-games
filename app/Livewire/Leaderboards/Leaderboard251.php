<?php

namespace App\Livewire\Leaderboards;

use App\Models\Score;
use Livewire\Component;

class Leaderboard251 extends Component
{

    public array $rankings = [];

    public array $rankingsRx = [];

    public array $rankingsScaled = [];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->rankings = Score::individualRankingOpenWod251()->toArray();
        $this->rankingsRx = Score::individualRankingOpenWod251('rx')->toArray();
        $this->rankingsScaled = Score::individualRankingOpenWod251('scaled')->toArray();
    }
}
