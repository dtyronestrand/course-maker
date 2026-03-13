<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliverableController extends Controller
{
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'offset_days' => 'required|integer',
        ]);

        $deliverable = new \App\Models\Deliverable($validated);
        $deliverable->save();

        return back()->with(['message' => 'Deliverable created successfully', 'deliverable' => $deliverable]);
    }
}
