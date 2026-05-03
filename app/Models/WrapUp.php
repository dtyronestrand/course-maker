<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\IsModuleItem;
class WrapUp extends Model
{
    use IsModuleItem;

    protected $fillable = [
        'title',
        'content',
    ];
}
