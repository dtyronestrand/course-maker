<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DevelopmentCycle;
use App\Models\Deliverable;
use App\Models\User;
use Inertia\Inertia;
class DashboardController extends Controller
{
    public function index()
    {
        $query = Course::query()->with('developmentCycle', 'users.roles');
        $currentUser = auth()->user();

       
if (!$currentUser->hasRole('admin')) {
    $user_role = $currentUser->roles->pluck('name')->first();
    $courses = $query->whereHas('users', function ($q) use ($currentUser) {
         $q->where('id', $currentUser->id);
     })->get();
 } else {
     $courses = $query->get();
     $user_role = 'admin';
}

return Inertia::render('Dashboard', [
    'courses' => $courses,
    'user_role' => $user_role ?? null,
]);
    }
}