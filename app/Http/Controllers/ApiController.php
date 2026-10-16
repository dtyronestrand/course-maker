<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminSetting;
use App\Models\Course;

use App\Models\DevelopmentCycle;
class ApiController extends Controller
{
    public function leadDashboard()
    {
        $coursesNeedingAttention = Course::select('id', 'prefix', 'number', 'title')
            ->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('deliverables', function ($query) {
                $query->where('missed_due_date_count', '>', 0)
                    ->where('is_done', 0);
            })->with(['deliverables' => function($query){
                $query->select('deliverables.id', 'deliverables.name')
                    ->where('course_deliverable.missed_due_date_count', '>', 0)
                    ->where('course_deliverable.is_done', 0);
            }])->with('users')->get();

            $users = User::select('id', 'first_name', 'last_name')->where('current_team_id', auth()->user()->current_team_id)->with('roles', 'courses:id,prefix,number')->get();

            return response()->json([
                'coursesNeedingAttention' => $coursesNeedingAttention,
                'users' => $users
            ]);
    }
    public function adminDashboard()
    {
        $coursesNeedingAttention = Course::select('id', 'prefix', 'number', 'title')
            ->whereHas('deliverables', function ($query) {
                $query->where('missed_due_date_count', '>', 0)
                      ->where('is_done', 0);
            })->with(['deliverables' => function ($query) {
                $query->select('deliverables.id', 'deliverables.name')
                      ->where('course_deliverable.missed_due_date_count', '>', 0)
                      ->where('course_deliverable.is_done', 0);
            }])->with('users')->get();

        $courseStatusCounts = Course::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $activeCourseCount = Course::whereNotIn('status', ['pending', 'completed'])->count();

        $pendingCourseCount = Course::where('status', 'pending')->count();

        return response()->json([
            'coursesNeedingAttention' => $coursesNeedingAttention,
            'courseStatusCounts' => $courseStatusCounts,
            'activeCourseCount' => $activeCourseCount,
            'pendingCourseCount' => $pendingCourseCount
        ]);
    }
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
   public function usersWorkloads(){
    $users = User::select('id', 'first_name', 'last_name')->with('courses')->withCount('courses')->get();
    return response()->json(['users' => $users]);
  }

  public function capacity(){
    $setting = AdminSetting::where('key', 'Designer Capacity')->first();
    $capacity = $setting['value'];
    return response()->json(['capacity' => $capacity]);
  }
}
