<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DevelopmentCycle;
class ApiController extends Controller
{
  public function allUsersByRole()
  {
      $ids = \App\Models\User::with('roles')->whereHas('roles', function($q){
          $q->whereIn('name', ['id']);
      })->get();
      
      $smes = \App\Models\User::with('roles')->whereHas('roles', function($q){
          $q->whereIn('name', ['sme']);
      })->get();
      
      $leads = \App\Models\User::with('roles')->whereHas('roles', function($q){
          $q->whereIn('name', ['lead']);
      })->get();

      $cycles = DevelopmentCycle::select('id', 'name')->get();

      return response()->json([
          'ids' => $ids,
          'smes' => $smes,
          'leads' => $leads,
          'cycles' => $cycles
      ]);
  }
}
