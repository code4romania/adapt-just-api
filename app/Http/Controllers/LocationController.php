<?php

namespace App\Http\Controllers;

use App\Http\Resources\Location\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $locations = LocationService::locations()->get();
        return LocationResource::collection($locations);
    }

}
