<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $query = User::query()->with('currentTeam');
       
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
        })->with('currentTeam');
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
        return Inertia::render('users/Teams', [
            'users' => $users,
            'teams' => $teams ?? null
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
