<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
  protected $fillable = [
    'module_id',
    'itemable_id',
    'itemable_type',
    'order',
  ];

  public function itemable(): MorphTo
  {
    return $this->morphTo();
  }

  public function module(): BelongsTo
  {
    return $this->belongsTo(Module::class);
  }
}
