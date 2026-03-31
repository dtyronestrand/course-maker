<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query()->with('developmentCycle', 'users.roles');
        $currentUser = $request->user();
        $isAdmin = $currentUser->hasRole('admin');

        if (! $isAdmin) {
            $courses = $query->whereHas('users', function ($q) use ($currentUser) {
                $q->where('id', $currentUser->id);
            })->get();
        } else {
            $courses = $query->get();
        }

        return Inertia::render('Dashboard', [
            'courses' => $courses,
            'is_admin' => $isAdmin,
        ]);
    }
}