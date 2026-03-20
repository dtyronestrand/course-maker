<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuinate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
class TeamController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $members = User::where('current_team_id', $user->current_team_id)->with(['roles', 'courses'])->get();
        $team = Team::find($user->current_team_id);
        return Inertia::render('users/team', [
            'members' => $members,
            'team' => $team,
        ]);
    }
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array|min:1',
        ]);

        $team = Team::findOrFail($id);
        $team->update([
            'name' => $request->name
        ]);

        // Remove users no longer in the team
\App\Models\User::where('current_team_id', $team->id)
    ->whereNotIn('id', $request->users)
    ->update(['current_team_id' => null]);

// Add/update users in the team
\App\Models\User::whereIn('id', $request->users)
    ->update(['current_team_id' => $team->id]);

        return redirect()->back()->with('success', 'Team updated successfully.');
    }
}
