<?php

namespace App\Services;

use App\Models\Location;
use Spatie\QueryBuilder\QueryBuilder;

class LocationService
{
    public static function locations()
    {
        return QueryBuilder::for(Location::class);
    }

}
