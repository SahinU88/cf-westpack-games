<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ScoresOpenWod254 extends Component
{
    public ?Score $scoreObj = null;

    public int $reps = 0;

    public string $tiebreak = '';

    public string $division = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->scoreObj = Auth::user()->scores()->openWod254()->first();

        if ($this->scoreObj === null) {
            $this->scoreObj = Auth::user()->scores()->create([
                'name' => 'Bonus WOD 25.4',
                'data' => [
                    'reps' => 0,
                    'tiebreak' => '00:00',
                    'type' => 'reps-with-tiebreak',
                ],
                'division' => '',
            ]);
        }

        $this->reps = $this->scoreObj->data['reps'];
        $this->tiebreak = $this->scoreObj->data['tiebreak'];
        $this->division = $this->scoreObj->division ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateScore(): void
    {
        $user = Auth::user();

        if (now()->greaterThanOrEqualTo(Carbon::parse('26.03.2025'))) {
            $this->dispatch('score-deadline-passed', name: $user->name);

            return;
        }

        $validated = $this->validate([
            'reps' => ['required', 'integer', 'min:0'],

            'tiebreak' => ['sometimes', 'string', 'date_format:H:i'],

            'division' => [
                'required',
                'string',
                Rule::in(['rx', 'scaled']),
            ],
        ]);

        $user->scores()->updateOrCreate(
            [
                'name' => 'Bonus WOD 25.4',
            ],
            [
                'data' => [
                    'reps' => $validated['reps'],
                    'tiebreak' => $validated['tiebreak'],
                    'type' => 'reps-with-tiebreak',
                ],
                'division' => $validated['division'],
            ]
        );

        $this->dispatch('score-submitted', name: $user->name);
    }
}
