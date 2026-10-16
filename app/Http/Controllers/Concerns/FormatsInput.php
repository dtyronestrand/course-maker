<?php

namespace App\Http\Controllers\Concerns;

trait FormatsInput
{
    protected function toTitleCase(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
}
