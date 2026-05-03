<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\IsModuleItem;

class Quiz extends Model
{
   protected $fillable = [
    'title',
    'instructions',
    'settings',
    'questions',
   ];

   
}
