<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateCourse;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $courses = Course::all()->load('users', 'developmentCycle', 'deliverables');
     return inertia('courses/Index', ['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('CourseController: store method called', ['request_data' => $request->all()]);
        
        $data = $request->validate([
            'prefix' => 'required|string|max:10',
            'number' => 'required|integer',
            'title' => 'required|string|max:255',
            'development_cycle' => 'nullable|integer',
            'objectives' => 'nullable|array',
            'objectives.*.number' => 'required_with:objectives|string|max:10',
            'objectives.*.objective' => 'required_with:objectives|string|max:255',
            'users' => 'nullable|array',
            'users.*.id' => 'required_with:users|exists:users,id',
        ]);
        
        Log::info('CourseController: validation passed', ['validated_data' => $data]);
        
        // Transform data for CreateCourse action
        if (isset($data['users'])) {
            $data['users'] = collect($data['users'])->pluck('id', 'role')->toArray();
        }
        
        Log::info('CourseController: data transformed', ['transformed_data' => $data]);
        
        $createCourse = new CreateCourse();
        $createCourse->handle($data);
        
        Log::info('CourseController: course creation completed');
        
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
