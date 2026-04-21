<?php

use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\DevelopmentCycleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Models\DevelopmentCycle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
    Route::get('/users/team', [TeamController::class, 'index'])->name('users.team');
    Route::get('users/teams', [UserController::class, 'teams'])->name('users.teams');
    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::put('/users', [UserController::class, 'add'])->name('users.add');
    Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.delete');
    Route::post('/development_cycles', [DevelopmentCycleController::class, 'store'])->name('developmentcycles.store');
    Route::post('/deliverables', [DeliverableController::class, 'store'])->name('deliverables.store');
    Route::delete('/deliverables/{deliverable}', [DeliverableController::class, 'destroy'])->name('deliverables.destroy');
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
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin_settings', [AdminSettingController::class, 'index'])->name('adminsettings.index');
    Route::post('/admin_settings', [AdminSettingController::class, 'store'])->name('adminsettings.store');
});

require __DIR__.'/settings.php';
