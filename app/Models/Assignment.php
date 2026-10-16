<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\IsModuleItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Rubric;
class Assignment extends Model
{
    use IsModuleItem;

    protected $fillable = [
        'title',
        'purpose',
        'criteria',
       'settings',
        'rubric_id',
    ];

    protected $casts = [
        'settings' => 'array',
    ];
    
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }
}
