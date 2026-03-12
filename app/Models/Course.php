<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
     'prefix',
     'number',
     'title',
     'users',
     'development_cycle_id'


    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function developmentCycle()
    {
        return $this->belongsTo(DevelopmentCycle::class);
    }
}
