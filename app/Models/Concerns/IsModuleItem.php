<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Item;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @method \Illuminate\Database\Eloquent\Relations\MorphOne morphOne(string $related, string $name, string $type = null, string $id = null, string $localKey = null)
 */
trait IsModuleItem
{
    public function item(): MorphOne
    {
        return $this->morphOne(Item::class, 'itemable');
    }
}