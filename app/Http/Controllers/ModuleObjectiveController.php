<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleObjective;

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

public function update(Request $request, Module $module, ModuleObjective $moduleObjective)
{
    $validated = $request->validate([
        'number' => 'required|string',
        'objective' => 'required|string',
        'course_objective_ids' => 'nullable|array',
        'course_objective_ids.*' => 'exists:course_objectives,id',

    ]);

    $moduleObjective->update([
        'number' => $validated['number'],
        'objective' => $validated['objective'],
    ]);

    if(isSet($validated['course_objective_ids'])) {
        $moduleObjective->courseObjectives()->sync($validated['course_objective_ids']);
    } else {
        $moduleObjective->courseObjectives()->detach();
    }

    return back()->with('success', 'Module objective updated successfully.');
}

public function destroy(Module $module, ModuleObjective $moduleObjective)
{
    $moduleObjective->delete();

    return back()->with('success', 'Module objective deleted successfully.');

}
}
