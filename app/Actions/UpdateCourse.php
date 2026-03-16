<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Deliverable;
use Carbon\Carbon;

class UpdateCourse {
    public function handle (Course $course, array $data){
        Log::info('UpdateCourse started:', [
            'course_id' => $course->id,
            'data_keys' => array_keys($data)
        ]);
        
        DB::transaction(function() use ($course, $data) {
            Log::info('Starting course update transaction');
            
            $course->update([
                'prefix' => $data['prefix'],
                'number' => $data['number'],
                'title' => $data['title'],
                'development_cycle_id' => $data['development_cycle']['id'],
            ]);
            
            Log::info('Course basic info updated successfully');
            
            if(isset($data['objectives'])) {
                Log::info('Updating course objectives:', ['count' => count($data['objectives'])]);
                $course->course_objectives()->delete();
                foreach ($data['objectives'] as $objectiveData) {
                    $course->course_objectives()->create([
                        'number' => $objectiveData['number'],
                        'objective' => $objectiveData['objective'],
                    ]);
                }
                Log::info('Course objectives updated successfully');
            }
            
            if(isset($data['users'])) {
                Log::info('Updating course users:', [
                    'course_id' => $course->id,
                    'users_data' => $data['users'],
                    'users_count' => count($data['users'])
                ]);
                
                // Check current users before detaching
                $currentUsers = $course->users()->get();
                Log::info('Current users before detach:', [
                    'count' => $currentUsers->count(),
                    'user_ids' => $currentUsers->pluck('id')->toArray()
                ]);
                
                $course->users()->detach();
                Log::info('Detached existing users from course');
                
                foreach ($data['users'] as $index => $user) {
                    Log::info('Processing user attachment:', [
                        'index' => $index,
                        'user_data' => $user,
                        'user_id_type' => gettype($user['id'] ?? 'missing'),
                        'role_type' => gettype($user['role'] ?? 'missing')
                    ]);
                    
                    try {
                        $result = $course->users()->attach($user['id'], ['role' => $user['role']]);
                        Log::info('User attached successfully:', [
                            'user_id' => $user['id'],
                            'role' => $user['role'],
                            'attach_result' => $result
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to attach user:', [
                            'user_id' => $user['id'] ?? 'missing',
                            'role' => $user['role'] ?? 'missing',
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                }
                
                // Verify users were attached
                $newUsers = $course->users()->get();
                Log::info('Users after attachment:', [
                    'count' => $newUsers->count(),
                    'user_ids' => $newUsers->pluck('id')->toArray(),
                    'users_with_roles' => $newUsers->map(function($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'role' => $user->pivot->role ?? 'no_role'
                        ];
                    })->toArray()
                ]);
            }
            
            Log::info('UpdateCourse transaction completed successfully');
        });
        
        Log::info('UpdateCourse finished successfully');
    }
}