<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseObjective extends Model
{
    protected $fillable=['number','objective','course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function moduleObjectives(): BelongsToMany
    {
        return $this->belongsToMany(ModuleObjective::class)->withTimestamps();
    }
}
