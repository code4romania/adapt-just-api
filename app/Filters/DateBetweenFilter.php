<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateBetweenFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (! empty($value[0])) {
            $query->whereDate($property, '>=', $value[0]);
        }

        if (! empty($value[1])) {
            $query->whereDate($property, '<=', $value[1]);
        }

        return $query;
    }
}
