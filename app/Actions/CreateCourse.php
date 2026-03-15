<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Deliverable;
use Carbon\Carbon;
class CreateCourse {
    public function __construct() {
        Log::info('CreateCourse: Class instantiated');
    }
    
    public function handle (array $data){
        Log::info('CreateCourse: handle method called', ['data' => $data]);
        
        try {
            Log::info('CreateCourse: Starting course creation', ['data' => $data]);
            
            DB::transaction(function() use ($data) {
                $course = Course::create([
                    'prefix' => $data['prefix'],
                    'number' => $data['number'],
                    'title' => $data['title'],
                    'development_cycle_id' => $data['development_cycle'],
                ]);
                Log::info('CreateCourse: Course created', ['course_id' => $course->id]);
                
                if(isset($data['objectives'])) {
                    foreach ($data['objectives'] as $objectiveData) {
                        $course->course_objectives()->create([
                            'number' => $objectiveData['number'],
                            'objective' => $objectiveData['objective'],
                        ]);
                    }
                    Log::info('CreateCourse: Objectives attached');
                }
                if(isset($data['users'])) {
                    foreach ($data['users'] as $role => $userId) {
                        $course->users()->attach($userId, ['role' => $role]);
                    }
                    Log::info('CreateCourse: Users attached');
                }

                $this->attachDeliverables($course);
            });
            
            Log::info('CreateCourse: Course creation completed successfully');
        } catch (\Exception $e) {
            Log::error('CreateCourse: Failed to create course', [
                'error' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function attachDeliverables(Course $course) {
        try {
            $deliverables = Deliverable::all();
            Log::info('CreateCourse: Found deliverables', ['count' => $deliverables->count()]);
            
            $course->load('developmentCycle');
            $pivotData = [];

            foreach ($deliverables as $deliverable) {
                $pivotData[$deliverable->id] = [
                    'due_date' => $course->developmentCycle && $course->developmentCycle->start_date
                        ? Carbon::parse($course->developmentCycle->start_date)->addDays($deliverable->offset_days)
                        : null,
                    'is_done' => false,
                    'missed_due_date_count' => 0,
                ];
            }
            
            $course->deliverables()->sync($pivotData);
            Log::info('CreateCourse: Deliverables attached', ['deliverable_count' => count($pivotData)]);
        } catch (\Exception $e) {
            Log::error('CreateCourse: Failed to attach deliverables', [
                'course_id' => $course->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}