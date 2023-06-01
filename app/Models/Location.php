<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'label',
        'email',
        'county_iso',
        'county_name',
        'county_label',
        'city_name',
        'city_label',
        'lat',
        'lng'
    ];

}
