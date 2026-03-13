<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
  protected $fillable = ['name', 'offset_days'];

  public function course() {
    return $this->belongsToMany(Course::class);
  }
}
