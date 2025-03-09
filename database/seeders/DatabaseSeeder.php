<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teams = $this->createTeams();
        $teams->each(fn($team) => $this->createTeamMembers($team));

        $teams
            ->each(fn($team) => $team->load('users'))
            ->each(function($team) {
                $users = $team->users->take(5);

                $users->each(fn($user) => $this->addScoreFor251($user));
                $users->each(fn($user) => $this->addScoreFor252($user));
            });

        Artisan::call('app:generate-empty-score-for-251');
        Artisan::call('app:generate-empty-score-for-252');
    }

    private function createTeams(): Collection
    {
        $this->createTeam('Bum Tschak');
        $this->createTeam('The Weight Swifters');
        $this->createTeam('Westpack Unbroken');

        $teamName = 'Sashimi';

        $team = Team::factory()
            ->create([
                'name' => $teamName,
                'slug' => str()->slug($teamName),
            ]);

        User::factory()
            ->isTeamCaptain()
            ->for($team)
            ->has(Profile::factory())
            ->create([
                'name' => 'Sahin',
                'email' => 'sahin.ucar.su@gmail.com',
            ]);

        return Team::with('users')->get();
    }

    private function createTeam(string $name): void
    {
        $team = Team::factory()
            ->create([
                'name' => $name,
                'slug' => str()->slug($name),
            ]);

        User::factory()
            ->isTeamCaptain()
            ->for($team)
            ->has(Profile::factory())
            ->create();
    }

    private function createTeamMembers(Team $team): void
    {
        User::factory()
            ->count(9)
            ->for($team)
            ->has(Profile::factory())
            ->create();
    }

    private function addScoreFor251(User $user): void
    {
        $user->scores()->create([
            'name' => 'Open WOD 25.1',
            'data' => [
                'score' => fake()->numberBetween(100, 300),
                'type' => 'reps',
            ],
            'division' => fake()->randomElement(['rx', 'scaled']),
        ]);
    }

    private function addScoreFor252(User $user): void
    {
        $finishedWod = fake()->boolean;
        $time = sprintf('%02d:%02d', fake()->numberBetween(5, 11), fake()->numberBetween(1, 59));

        $user->scores()->create([
            'name' => 'Open WOD 25.2',
            'data' => [
                'finishedWod' => $finishedWod,
                'reps' => $finishedWod ? 0 : fake()->numberBetween(1, 215),
                'time' => $finishedWod ? $time : sprintf('%02d:%02d', fake()->numberBetween(0, 11), fake()->numberBetween(0, 59)),
                'tiebreak' => sprintf('%02d:%02d', fake()->numberBetween(0, 11), fake()->numberBetween(0, 59)),
                'type' => 'time-or-reps',
            ],
            'division' => fake()->randomElement(['rx', 'scaled']),
        ]);
    }
}
