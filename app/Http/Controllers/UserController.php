<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $query = User::query()->with('currentTeam');

        if (!auth()->user()->hasRole('admin')) {
            $query->where('current_team_id', auth()->user()->current_team_id);
        }

        return Inertia::render('Users/Index', [
            'users' => $query->get()
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return Inertia::render('Users/Show', [
            'user' => $user->load('currentTeam')
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user);
    }
}
