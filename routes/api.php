<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentCycleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route to create API token (for testing)
Route::post('/create-token', function (Request $request) {
    $user = \App\Models\User::first(); // Get first user for testing
    if (!$user) {
        return response()->json(['error' => 'No users found'], 404);
    }
    
    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->get('/development-cycles', [DevelopmentCycleController::class, 'index']);

Route::middleware('auth:sanctum')->get('/allUsers', [\App\Http\Controllers\ApiController::class, 'allUsers']);