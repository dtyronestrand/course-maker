<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Module extends Model
{
protected $fillable = [
    'course_id',
    'title',
    'number',
   'order',

];

public function moduleObjectives(): HasMany
{
    return $this->hasMany(ModuleObjective::class);
}

  public function course()
  {
      return $this->belongsTo(Course::class);
  }

  public function items(): HasMany
  {
    return $this->hasMany(Item::class);
  }
}
