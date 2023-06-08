<?php

namespace App\Services;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UploadService
{

    public static function create($data): Model|Builder
    {
        return Upload::create($data);
    }
}
