<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserNameFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $value = mb_strtolower($value, 'UTF8');

        $query
            ->whereRaw("LOWER(first_name) LIKE ?", ["%{$value}%"])
            ->orWhereRaw("LOWER(last_name) LIKE ?", ["%{$value}%"]);
    }
}
