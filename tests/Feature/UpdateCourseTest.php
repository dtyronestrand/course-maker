<?php

namespace Tests\Feature;

use App\Actions\UpdateCourse;
use App\Models\Course;
use App\Models\User;
use App\Models\DevelopmentCycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UpdateCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_course_performance()
    {
        $cycle = DevelopmentCycle::create([
            'name' => 'Test Cycle',
        ]);

        $course = Course::create([
            'prefix' => 'CS',
            'number' => '101',
            'title' => 'Intro',
            'development_cycle_id' => $cycle->id,
        ]);

        $users = User::factory()->count(1000)->create();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->id,
                'role' => 'instructor',
            ];
        }

        $action = new UpdateCourse();

        $data = [
            'prefix' => 'CS',
            'number' => '101',
            'title' => 'Intro to Computer Science',
            'development_cycle_id' => $cycle->id,
            'development_cycle' => ['id' => $cycle->id],
            'users' => $userData,
        ];

        DB::enableQueryLog();

        $start = microtime(true);
        $action->handle($course, $data);
        $end = microtime(true);

        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        $this->assertEquals(1000, $course->users()->count());

        echo "\nTime taken for 1000 users: " . ($end - $start) . " seconds\n";
        echo "Queries executed: " . $queryCount . "\n";
    }
}
