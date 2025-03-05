<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ScoresOpenWod251 extends Component
{
    public ?Score $scoreObj = null;

    public int $score = 0;

    public string $division = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->scoreObj = Auth::user()->scores()->openWod25_1()->first();

        if ($this->scoreObj === null) {
            $this->scoreObj = Auth::user()->scores()->create([
                'name' => 'Open WOD 25.1',
                'data' => [
                    'score' => 0,
                    'type' => 'reps',
                ],
                'division' => '',
            ]);
        }

        $this->score = $this->scoreObj->data['score'] ?? 0;
        $this->division = $this->scoreObj->division ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateScore(): void
    {
        $user = Auth::user();

        if (now()->gt(Carbon::parse('01.03.2025 23:59:59'))) {
            $this->dispatch('score-deadline-passed', name: $user->name);

            return;
        }

        $validated = $this->validate([
            'score' => ['required', 'int', 'min:0'],

            'division' => [
                'required',
                'string',
                Rule::in(['rx', 'scaled']),
            ],
        ]);

        $user->scores()->updateOrCreate(
            [
                'name' => 'Open WOD 25.1',
            ],
            [
                'data' => [
                    'score' => $validated['score'],
                    'type' => 'reps',
                ],
                'division' => $validated['division'],
            ]
        );

        $this->dispatch('score-submitted', name: $user->name);
    }
}
