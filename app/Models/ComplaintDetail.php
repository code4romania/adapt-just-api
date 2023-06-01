<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'complaint_id',
        'type',
        'description',
    ];

}
