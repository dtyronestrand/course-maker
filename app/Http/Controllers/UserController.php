<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $query = User::query()->with('currentTeam', 'courses', 'roles');
        $teams = \App\Models\Team::all()->map(fn($team) => ['id' => $team->id, 'name' => $team->name])->values();
        /** @var User $currentUser */
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
         $users = $query->where('current_team_id', $currentUser->current_team_id)->get();
        } else {
              $users = $query->get();
            
        }
       
        $users->each(fn($user) => $user->role = $user->getRoleNames()->first());
        return Inertia::render('users/Index', [
            'users' => $users,
            'teams' => $teams,
        
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return Inertia::render('users/Show', [
            'user' => $user->load('currentTeam')
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('users/Edit', [
            'user' => $user
        ]);
    }

    public function teams(){
      $this->authorize('viewAny', User::class);

        $query = User::query()->whereHas('roles', function($q){
            $q->whereIn('name', ['lead', 'id']);
        })->with('currentTeam', 'roles');
        $teams = null;
        
        /** @var User $currentUser */
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
         $users = $query->where('current_team_id', $currentUser->current_team_id)->get();
        } else {
              $users = $query->get();
              $teams = \App\Models\Team::with(['users' => function($query) {
                  $query->with('roles');
              }])->get()->keyBy('id');
              
              $teams->each(function($team) {
                  $team->users->each(fn($user) => $user->role = $user->getRoleNames()->first());
              });
        }
      
        $users->each(fn($user) => $user->role = $user->getRoleNames()->first());
        return Inertia::render('users/teams', [
            'users' => $users,
            'teamsProp' => $teams ?? null
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user);
    }

    public function add(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:id,lead,admin',
        ]);

        $password = str()->random(12);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($password),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index');
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        $user->destroy($user->id);

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
