<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\DevelopmentCycle;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
 public function index()
 {
        $settings = AdminSetting::all()->pluck('value', 'key');
        $developmentCycles = DevelopmentCycle::all();
        return Inertia::render('AdminSettings', [
            'settings' => $settings,
            'developmentCycles' => $developmentCycles,
        ]);
 }

 public function store(Request $request){
    \Log::info('AdminSetting store method called', [
        'request_data' => $request->all()
    ]);

    $request->validate([
        'key' => 'required|string|max:255',
        'value' => 'nullable',
    ]);

    $setting = AdminSetting::updateOrCreate(
        ['key' => $request->key],
        ['value' => $request->value]
    );
    
    \Log::info('AdminSetting saved', [
        'setting' => $setting->toArray()
    ]);
    
    return redirect()->back()->with('success', 'Setting saved successfully.');
 }
}
