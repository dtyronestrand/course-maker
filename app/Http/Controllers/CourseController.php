<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Actions\CreateCourse;
use App\Actions\UpdateCourse;
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
        Log::info('CourseController: store method called', ['request_data' => $request->except(['password', 'password_confirmation', 'token', 'secret_tokens'])]);
        
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
            'users.*.role' => 'required_with:users|string|max:50',
        ]);
        
        Log::info('CourseController: validation passed', ['validated_data' => $data]);
        
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

    public function update(Request $request, Course $course)
    {
        Log::info('CourseController: update method called', [
            'course_id' => $course->id,
            'request_data' => $request->except(['password', 'password_confirmation', 'token', 'secret_tokens']),
            'request_method' => $request->method(),
            'request_url' => $request->url()
        ]);
        
        $data = $request->validate([
            'prefix' => 'required|string|max:10',
            'number' => 'required|integer',
            'title' => 'required|string|max:255',
            'development_cycle' => 'nullable|array',
            'development_cycle.id' => 'required_with:development_cycle|integer',
            'objectives' => 'nullable|array',
            'objectives.*.number' => 'required_with:objectives|string|max:10',
            'objectives.*.objective' => 'required_with:objectives|string|max:255',
            'users' => 'nullable|array',
            'users.*.id' => 'required_with:users|exists:users,id',
            'users.*.role' => 'required_with:users|string|max:50',
        ]);
        
        Log::info('CourseController: validation passed', [
            'validated_data' => $data,
            'has_users' => isset($data['users']),
            'users_count' => isset($data['users']) ? count($data['users']) : 0
        ]);

        $updateCourse = new UpdateCourse();
        $updateCourse->handle($course, $data);
        
        Log::info('CourseController: course update completed');

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
