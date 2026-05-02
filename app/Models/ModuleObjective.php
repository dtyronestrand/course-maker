<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ModuleObjective extends Model
{
    protected $fillable = [
        'module_id',
        'number',
        'objective',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function courseObjectives(): BelongsToMany
    {
        return $this->belongsToMany(CourseObjective::class)->withTimestamps();
    }
}
