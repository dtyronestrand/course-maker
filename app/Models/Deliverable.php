<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
  protected $fillable = ['name', 'offset_days'];

  public function course() {
    return $this->belongsToMany(Course::class)->withPivot('due_date', 'is_done', 'date_completed', 'missed_due_date_count')->withTimestamps();
  }
}
