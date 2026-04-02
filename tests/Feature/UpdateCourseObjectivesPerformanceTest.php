<?php

namespace Tests\Feature;

use App\Actions\UpdateCourse;
use App\Models\Course;
use App\Models\DevelopmentCycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UpdateCourseObjectivesPerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_course_objectives_performance()
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

        $action = new UpdateCourse();

        $objectivesData = [];
        for ($i = 1; $i <= 100; $i++) {
            $objectivesData[] = [
                'number' => $i,
                'objective' => "Objective $i",
            ];
        }

        $data = [
            'prefix' => 'CS',
            'number' => '101',
            'title' => 'Intro to Computer Science',
            'development_cycle_id' => $cycle->id,
            'development_cycle' => ['id' => $cycle->id],
            'objectives' => $objectivesData,
        ];

        DB::enableQueryLog();

        $start = microtime(true);
        $action->handle($course, $data);
        $end = microtime(true);

        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        $this->assertEquals(100, $course->course_objectives()->count());

        echo "\nTime taken for 100 objectives: " . ($end - $start) . " seconds\n";
        echo "Queries executed: " . $queryCount . "\n";
    }
}
