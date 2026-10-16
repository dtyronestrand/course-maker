<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubric extends Model
{
   protected $fillable = [
    'title',
    'criteria',
   ];

   public function assignments(): HasMany
   {
       return $this->hasMany(Assignment::class);
   }

   public function discussions(): HasMany
   {
       return $this->hasMany(Discussion::class);
   }
}
