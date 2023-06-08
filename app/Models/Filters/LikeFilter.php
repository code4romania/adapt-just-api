<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class LikeFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $value = mb_strtolower($value, 'UTF8');

        $query->whereRaw("$property LIKE ?", ["%{$value}%"]);
    }
}
