<?php

namespace App\Livewire\Teams;

use App\Models\Score;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
