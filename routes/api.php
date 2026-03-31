<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentCycleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/development-cycles', [DevelopmentCycleController::class, 'index']);

Route::middleware('auth:sanctum')->get('/users', [\App\Http\Controllers\ApiController::class, 'allUsersByRole']);

Route::middleware('auth:sanctum')->get('/users-workloads', [\App\Http\Controllers\ApiController::class, 'usersWorkloads']);
Route::middleware('auth:sanctum')->get('/admin-dashboard', [\App\Http\Controllers\ApiController::class, 'adminDashboard']);
Route::middleware('auth:sanctum')->get('/capacity', [\App\Http\Controllers\ApiController::class, 'capacity']);