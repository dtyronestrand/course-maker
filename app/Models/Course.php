<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deliverable;
use Carbon\Carbon;
class Course extends Model
{
    protected $fillable = [
     'prefix',
     'number',
     'title',
     'users',
     'development_cycle_id'


    ];
    public function attachAllDeliverables(Course $course) {
        $deliverables = Deliverable::all();
        $course->load('developmentCycle');

        $pivotData = [];

        foreach ($deliverables as $deliverable) {
            $pivotData[$deliverable->id] = [
                'due_date' => Carbon::parse($course->developmentCycle->start_date->addDays($deliverable->offset_days)),
                'is_done' => false,
                'missed_due_date_count' => 0,
            ];
        }

        $course->deliverables()->sync($pivotData);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function developmentCycle()
    {
        return $this->belongsTo(DevelopmentCycle::class);
    }

    public function deliverables() {
        return $this->belongsToMany(Deliverable::class)->withPivot('due_date', 'is_done', 'date_completed', 'missed_due_date_count')->withTimestamps();
    }

    public function course_objectives() {
        return $this->hasMany(CourseObjective::class);
    }
}
