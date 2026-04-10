<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::factory()->count(3)->create();

        foreach ($teams as $team) {
            User::factory()->create([
                'current_team_id' => $team->id,
            ])->assignRole('lead');

            User::factory()->count(5)->create([
                'current_team_id' => $team->id,
            ])->each(function ($user) {
                $user->assignRole('id');
            });
        }
    }
}
