<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
protected $fillable = [
    'course_id',
    'title',
    'number',
    'items',
    'module_objectives',
    'order_index',

];

protected $casts = [
    'module_objectives' => 'array',
];

  public function course()
  {
      return $this->belongsTo(Course::class);
  }
}
