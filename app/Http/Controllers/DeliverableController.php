<?php

namespace App\Http\Controllers;

use App\Models\Deliverable;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\FormatsInput;
class DeliverableController extends Controller
{
    use FormatsInput;

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'offset_days' => 'required|integer',
        ]);
        $validated['name'] = $this->toTitleCase($validated['name']);
        $deliverable = new \App\Models\Deliverable($validated);
        $deliverable->save();

        return back()->with(['message' => 'Deliverable created successfully', 'deliverable' => $deliverable]);
    }

    public function destroy(Deliverable $deliverable)
    {
        $deliverable->delete();

        return back()->with('message', 'Deliverable deleted successfully');
    }
}
