<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;

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

require __DIR__.'/settings.php';