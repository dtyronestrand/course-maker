<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Item;

class ItemController extends Controller
{
    public function store(Request $request, Module $module)
    {
        $validated = $request->validate([
            'type' => 'required|in:page,discussion,wrap_up,assignment,quiz',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'purpose' => 'nullable|string',
            'criteria' => 'nullable|string',
            'settings' => 'nullable|json',
            'module_objective_ids' => 'nullable|array',
            'module_objective_ids.*' => 'exists:module_objectives,id',
        ]);

        $itemClass = match($validated['type']) {
            'page' => \App\Models\Page::class,
            'discussion' => \App\Models\Discussion::class,
            'wrap_up' => \App\Models\WrapUp::class,
            'assignment' => \App\Models\Assignment::class,
            'quiz' => \App\Models\Quiz::class,
        };

        $specificItem = $itemClass::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'purpose' => $validated('purpose') ?? null,
            'criteria' => $validated('criteria') ?? null,
            'settings' => $validated('settings') ?? null,

        ]);

        $nextOrder = $module->items()->max('order') + 1;

        $itemWrapper = $module->items()->create([
            'itemable_id' => $specificItem->id,
            'itemable_type' => $itemClass,
            'order' => $nextOrder,
        ]);

        if(!empty($validated['module_objective_ids'])) {
            $itemWrapper->moduleObjectives()->sync($validated['module_objective_ids']);
        }

        return back()->with('success', 'Item created successfully.');
    }

    public function update(Request $request, Module $module, Item $item)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'purpose' => 'nullable|string',
            'criteria' => 'nullable|string',
            'settings' => 'nullable|json',
            'module_objective_ids' => 'nullable|array',
            'module_objective_ids.*' => 'exists:module_objectives,id',
        ]);

        $specificItem = $item->itemable;
        $specificItem->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'purpose' => $validated('purpose') ?? null,
            'criteria' => $validated('criteria') ?? null,
            'settings' => $validated('settings') ?? null,
        ]);

        if(isSet($validated['module_objective_ids'])) {
            $item->moduleObjectives()->sync($validated['module_objective_ids']);
        } else {
            $item->moduleObjectives()->detach();
        }

        return back()->with('success', 'Item updated successfully.');
    }

    public function destroy(Module $module, Item $item)
    {
        if ($item->itemable) {
            $item->itemable->delete();
        }

        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }
}
