<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationsDummyDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $locations = json_decode(file_get_contents(__DIR__ . '/../dumps/locations.json'), true);
        Location::insert($locations);
    }
}
