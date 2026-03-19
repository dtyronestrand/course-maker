<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DevelopmentCycle;
class ApiController extends Controller
{
  public function allUsersByRole()
  {
      $users = \App\Models\User::with('roles')->whereHas('roles', function($q){
          $q->whereIn('name', ['id', 'sme', 'lead']);
      })->get();

      $ids = [];
      $smes = [];
      $leads = [];

      foreach ($users as $user) {
          foreach ($user->roles as $role) {
              if ($role->name === 'id') {
                  $ids[] = $user;
              }
              if ($role->name === 'sme') {
                  $smes[] = $user;
              }
              if ($role->name === 'lead') {
                  $leads[] = $user;
              }
          }
      }

      $cycles = DevelopmentCycle::select('id', 'name')->get();

      return response()->json([
          'ids' => collect($ids),
          'smes' => collect($smes),
          'leads' => collect($leads),
          'cycles' => $cycles
      ]);
  }
}
