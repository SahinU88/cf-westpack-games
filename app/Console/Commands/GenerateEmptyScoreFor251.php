<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateEmptyScoreFor251 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-empty-score-for-251';

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
            $score = $user->scores()->openWod251()->first();

            if ($score === null)
            {
                $user->scores()->create([
                    'name' => 'Open WOD 25.1',
                    'data' => [
                        'score' => 0,
                        'type' => 'reps',
                    ],
                    'division' => $user->profile->division,
                ]);
            }
        });
    }
}
