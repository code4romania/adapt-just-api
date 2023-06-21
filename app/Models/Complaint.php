<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Complaint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'register_number',
        'victim',
        'type',
        'name',
        'location_id',
        'location_name',
        'location_to_id',
        'location_to_name',
        'location_to_type',
        'details',
        'reason',
        'proof_type',
        'lat',
        'lng'
    ];

    protected $casts = [
        'details' => 'array'
    ];


    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo
     */
    public function locationTo(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }


    /**
     * @return BelongsToMany
     */
    public function uploads(): BelongsToMany
    {
        return $this->belongsToMany(Upload::class, 'complaint_uploads');
    }

}
