<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create SMEs who are NOT assigned to a team
        User::factory()->count(10)->create([
            'current_team_id' => null,
        ])->each(function ($user) {
            $user->assignRole('sme');
        });

        $smes = User::role('sme')->get();
        $teams = Team::all();

        Course::factory()->count(10)->create()->each(function ($course) use ($teams, $smes) {
            $team = $teams->random();

            $lead = User::role('lead')->where('current_team_id', $team->id)->first();
            $teamIds = User::role('id')->where('current_team_id', $team->id)->inRandomOrder()->get();
            $sme = $smes->random();

            if ($lead) {
                $course->users()->attach($lead->id, ['role' => 'lead']);
            }

            if ($teamIds->isNotEmpty()) {
                $course->users()->attach($teamIds->shift()->id, ['role' => 'designer']);
            }

            if ($teamIds->isNotEmpty()) {
                $course->users()->attach($teamIds->shift()->id, ['role' => 'builder']);
            }

            if ($sme) {
                $course->users()->attach($sme->id, ['role' => 'sme']);
            }

            $course->attachAllDeliverables($course);
            $course->setStatus();
        });
    }
}
