<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateEmptyScoreFor253 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-empty-score-for-253';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with(['team', 'profile'])->get();

        $users->each(function (User $user) {
            $score = $user->scores()->openWod253()->first();

            if ($score === null)
            {
                if ($user->profile()->doesntExist()) {
                    return;
                }

                $user->scores()->create([
                    'name' => 'Open WOD 25.3',
                    'data' => [
                        'finishedWod' => false,
                        'reps' => 0,
                        'time' => '00:00',
                        'tiebreak' => '00:00',
                        'type' => 'time-or-reps',
                    ],
                    'division' => $user->profile->division_for_score,
                ]);
            }
        });
    }
}
