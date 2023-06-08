<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'upload_id',
        'content',
        'short_content',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    /**
     * @return BelongsTo
     */
    public function upload(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }

}
