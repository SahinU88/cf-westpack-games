<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teams = $this->createTeams();
        $teams->each(fn($team) => $this->createTeamMembers($team));

        $users = User::with(['profile'])->get();
        $users->each(fn($user) => $this->addScoreFor252($user));
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

        return Team::all();
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

    private function addScoreFor252(User $user): void
    {
        $user->scores()->create([
            'name' => 'Open WOD 25.1',
            'data' => [
                'score' => fake()->numberBetween(100, 300),
                'type' => 'reps',
            ],
            'division' => $user->profile->division,
        ]);
    }
}
