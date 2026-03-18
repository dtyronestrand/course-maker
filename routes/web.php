<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\DevelopmentCycleController;
use App\Models\DevelopmentCycle;
use App\Models\User;
use App\Http\Controllers\CourseController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');

Route::get('users/teams', [UserController::class, 'teams'])->name('users.teams');
Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
Route::put('/users', [UserController::class, 'add'])->name('users.add');
Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.delete');
Route::get('/admin_settings', [\App\Http\Controllers\AdminSettingController::class, 'index'])->name('adminsettings.index');
Route::post('/admin_settings', [\App\Http\Controllers\AdminSettingController::class, 'store'])->name('adminsettings.store');
Route::post('/development_cycles', [DevelopmentCycleController::class, 'store'])->name('developmentcycles.store');
Route::post('/deliverables', [\App\Http\Controllers\DeliverableController::class, 'store'])->name('deliverables.store');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', function () {
    $user = User::select('id', 'name', 'role')->get();
    $cycles = DevelopmentCycle::select('id', 'name')->get();

    if (request()->wantsJson()) {
        return response()->json([
            'users' => $user,
            'cycles' => $cycles,
        ]);
    }
        return inertia('courses/Index', [
            'users' => $user,
            'cycles' => $cycles,
        ]);
})->name('courses.create');

Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');

require __DIR__.'/settings.php';