<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\IsModuleItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Rubric;

class Discussion extends Model
{
   use IsModuleItem;

    protected $fillable = [
        'title',
        'purpose',
        'settings',
        'criteria',
    ];

    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }
}
