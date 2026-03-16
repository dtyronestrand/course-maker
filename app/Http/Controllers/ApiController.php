<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
  public function allUsers()
  {
      $users = \App\Models\User::all();
      return response()->json($users);
  }
}
