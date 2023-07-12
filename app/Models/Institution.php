<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'county_iso',
        'county_name'
    ];

    protected $casts = [
        'type' => 'string',
        'name' => 'string',
        'email' => 'array',
        'county_iso' => 'string',
        'county_name' => 'string'
    ];

}
