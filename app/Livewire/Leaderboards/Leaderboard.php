<?php

namespace App\Livewire\Leaderboards;

use App\Models\Score;
use Illuminate\Support\Collection;
use Livewire\Component;

class Leaderboard extends Component
{

    public array $rankings;

    public array $rankingOpenWod251;

    public array $rankingOpenWod252;

    public array $rankingOpenWod253;

    public array $rankingOpenWod254;


    public function mount(): void
    {
        $this->rankingOpenWod251 = Score::teamRankingOpenWod251();
        $this->rankingOpenWod252 = Score::teamRankingOpenWod252();
        $this->rankingOpenWod253 = Score::teamRankingOpenWod253();
        $this->rankingOpenWod254 = Score::teamRankingOpenWod254();

        $this->rankings = collect($this->rankingOpenWod251)
            ->merge($this->rankingOpenWod252)
            ->merge($this->rankingOpenWod253)
            ->merge($this->rankingOpenWod254)
            ->groupBy('team.id')
            ->map(function (Collection $itemsForTeam) {
                $team = $itemsForTeam->first()['team'];
                $wod251 = $itemsForTeam->where('wod', '25.1')->first();
                $wod252 = $itemsForTeam->where('wod', '25.2')->first();
                $wod253 = $itemsForTeam->where('wod', '25.3')->first();
                $wod254 = $itemsForTeam->where('wod', '25.4')->first();

                return [
                    'team' => $team,
                    'total_points' => $itemsForTeam->sum('total_points'),
                    'points_251' => [
                        'total' => $wod251['total_points'] ?? 0,
                        'rx' => $wod251['scores_rx']['points'] ?? 0,
                        'scaled' => $wod251['scores_scaled']['points'] ?? 0,
                    ],
                    'points_252' => [
                        'total' => $wod252['total_points'] ?? 0,
                        'rx' => $wod252['scores_rx']['points'] ?? 0,
                        'scaled' => $wod252['scores_scaled']['points'] ?? 0,
                    ],
                    'points_253' => [
                        'total' => $wod253['total_points'] ?? 0,
                        'rx' => $wod253['scores_rx']['points'] ?? 0,
                        'scaled' => $wod253['scores_scaled']['points'] ?? 0,
                    ],
                    'points_254' => [
                        'total' => $wod254['total_points'] ?? 0,
                        'rx' => $wod254['scores_rx']['points'] ?? 0,
                        'scaled' => $wod254['scores_scaled']['points'] ?? 0,
                    ],
                ];
            })
            ->sortBy('total_points')
            ->values()
            ->toArray();
    }
}
