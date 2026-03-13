<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\DevelopmentCycle;
use App\Models\Deliverable;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
 public function index()
 {
        $settings = AdminSetting::all()->pluck('value', 'key');
        $developmentCycles = DevelopmentCycle::all();
        $deliverables = Deliverable::all();
        return Inertia::render('AdminSettings', [
            'settings' => $settings,
            'developmentCycles' => $developmentCycles,
            'deliverables' => $deliverables,
        ]);
 }

 public function store(Request $request){


    $request->validate([
        'key' => 'required|string|max:255',
        'value' => 'nullable',
    ]);

    $setting = AdminSetting::updateOrCreate(
        ['key' => $request->key],
        ['value' => $request->value]
    );
    

    
    return redirect()->back()->with('success', 'Setting saved successfully.');
 }
}
