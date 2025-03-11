<?php

namespace App\Livewire\Scores;

use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

use function Laravel\Prompts\error;

class ScoresOpenWod252 extends Component
{
    public ?Score $scoreObj = null;

    public string $finishedWod = 'No';

    public int $reps = 0;

    public string $time = '';

    public string $tiebreak = '';

    public string $division = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->scoreObj = Auth::user()->scores()->openWod252()->first();

        if ($this->scoreObj === null) {
            $this->scoreObj = Auth::user()->scores()->create([
                'name' => 'Open WOD 25.2',
                'data' => [
                    'finishedWod' => false,
                    'reps' => 0,
                    'time' => '00:00',
                    'tiebreak' => '00:00',
                    'type' => 'time-or-reps',
                ],
                'division' => '',
            ]);
        }

        $this->finishedWod = $this->scoreObj->data['finishedWod'] ? 'Yes' : 'No';
        $this->reps = $this->scoreObj->data['reps'];
        $this->time = $this->scoreObj->data['time'];
        $this->tiebreak = $this->scoreObj->data['tiebreak'];
        $this->division = $this->scoreObj->division ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateScore(): void
    {
        $user = Auth::user();

        if (now()->greaterThanOrEqualTo(Carbon::parse('12.03.2025'))) {
            $this->dispatch('score-deadline-passed', name: $user->name);

            return;
        }

        $validated = $this->validate([
            'finishedWod' => ['required', 'string', Rule::in(['Yes', 'No'])],

            'time' => ['required_if:finishedWod,true', 'date_format:H:i'],

            'reps' => ['required_if:finishedWod,false', 'integer', 'min:0'],

            'tiebreak' => ['sometimes', 'string', 'date_format:H:i'],

            'division' => [
                'required',
                'string',
                Rule::in(['rx', 'scaled']),
            ],
        ]);

        Log::info($validated);

        $user->scores()->updateOrCreate(
            [
                'name' => 'Open WOD 25.2',
            ],
            [
                'data' => [
                    'finishedWod' => $validated['finishedWod'] === 'Yes',
                    'reps' => $validated['reps'],
                    'time' => $validated['time'],
                    'tiebreak' => $validated['tiebreak'],
                    'type' => 'time-or-reps',
                ],
                'division' => $validated['division'],
            ]
        );

        $this->dispatch('score-submitted', name: $user->name);
    }
}
