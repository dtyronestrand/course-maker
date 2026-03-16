<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevelopmentCycleController extends Controller
{
    public function index()
    {
        $developmentCycles = \App\Models\DevelopmentCycle::all();
        return response()->json($developmentCycles);
    }
    
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $developmentCycle = \App\Models\DevelopmentCycle::create($validated);

        return back()->with('success', 'Development cycle created successfully.');
    }
}
