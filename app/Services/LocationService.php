<?php

namespace App\Services;

use App\Models\Complaint;
use Spatie\QueryBuilder\QueryBuilder;

class LocationService
{
    public static function locations()
    {
        return QueryBuilder::for(Complaint::class);
    }

}
