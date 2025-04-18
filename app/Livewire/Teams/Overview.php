<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    public Collection $teams;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->teams = Team::with(['users', 'users.profile'])->get();
    }
}
