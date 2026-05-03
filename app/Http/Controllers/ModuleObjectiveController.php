<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class ModuleObjectiveController extends Controller
{
    public function store(Request $request, Module $module)
    {
    $validated = $request->validate([
        'number' => 'required|integer',
        'objective' => 'required|string',
        'course_objective_ids' => 'nullable|array',
        'course_objective_ids.*' => 'exists:course_objectives,id',
    ]);

    $moduleObjective = $module->moduleObjectives()->create([
        'number' => $validated['number'],
        'objective' => $validated['objective'],
    ]);

    if(!empty($validated['course_objective_ids'])) {
        $moduleObjective->courseObjectives()->sync($validated['course_objective_ids']);
    }

    return back()->with('success', 'Module objective created successfully.');
}
}
