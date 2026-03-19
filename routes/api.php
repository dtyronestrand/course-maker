<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentCycleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/development-cycles', [DevelopmentCycleController::class, 'index']);

Route::middleware('auth:sanctum')->get('/users', [\App\Http\Controllers\ApiController::class, 'allUsersByRole']);