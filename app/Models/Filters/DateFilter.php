<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\Filters\Filter;

class DateFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $start = count($value) && $value[0] ? Carbon::parse($value[0]) : null;
        $end = count($value) && $value[1] ? Carbon::parse($value[1]) : null;

        if (!empty($start)) {
            $query->whereDate($property, ">=", $start)->get();
        }

        if (!empty($end)) {
            $query->whereDate($property, "<=", $end)->get();
        }
    }
}
