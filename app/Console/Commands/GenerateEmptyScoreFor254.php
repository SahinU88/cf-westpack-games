<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateEmptyScoreFor254 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-empty-score-for-254';

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
            $score = $user->scores()->openWod254()->first();

            if ($score === null)
            {
                if ($user->profile()->doesntExist()) {
                    return;
                }

                $user->scores()->create([
                    'name' => 'Bonus WOD 25.4',
                    'data' => [
                        'reps' => 0,
                        'tiebreak' => '00:00',
                        'type' => 'reps-with-tiebreak',
                    ],
                    'division' => $user->profile->division_for_score,
                ]);
            }
        });
    }
}
