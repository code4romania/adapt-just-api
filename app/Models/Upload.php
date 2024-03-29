<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name',
        'size',
        'path',
        'extension',
        'mime',
        'hash_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'size' => 'integer',
        'path' => 'string',
        'extension' => 'string',
        'mime' => 'string',
        'hash_name' => 'string'
    ];


    public function getDataUrlAttribute()
    {
        return Storage::disk()->temporaryUrl($this->path, now()->addDay(2));
    }

}
