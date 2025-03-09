<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use Illuminate\Support\Collection;
use Livewire\Component;

class Detail extends Component
{
    public Collection $teams;

    public Team $team;

    /**
     * Mount the component.
     */
    public function mount(Team $team): void
    {
        $this->team = $team->load(['users', 'users.profile']);
        $this->teams = Team::with(['users', 'users.profile'])->get();
    }
}
