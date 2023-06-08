<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\Filters\Filter;

class DateBetweenFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        if (!empty($value[0]) ) {
            $query->whereDate($property, ">=", $value[0]);
        }

        if (!empty($value[1])) {
            $query->whereDate($property, "<=", $value[1]);
        }

        return $query;
    }
}
