<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public $table = 'permissions';

    public $fillable = [
        'name',
        'module',
        'label',
        'guard_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'module' => 'string',
        'label' => 'string',
        'guard_name' => 'string',
    ];
}
