<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array|min:1',
        ]);

        $team = \App\Models\Team::create([
            'name' => $request->name
        ]);

        \App\Models\User::whereIn('id', $request->users)->update(['current_team_id' => $team->id]);

        

        return redirect()->back()->with('success', 'Team created successfully.');

    }
}
