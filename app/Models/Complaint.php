<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'complaint_type',
        'name',
        'location_id',
        'location_name',
        'location_to_id',
        'location_to_name',
        'has_proof',
    ];

    /**
     * @return BelongsToMany
     */
    public function uploads(): BelongsToMany
    {
        return $this->belongsToMany(Upload::class, 'complaint_uploads');
    }

    /**
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(ComplaintDetail::class);
    }
}
