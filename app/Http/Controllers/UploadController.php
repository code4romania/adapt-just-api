<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\Upload\CreateUploadApiRequest;
use App\Http\Requests\Upload\StoreUploadRequest;
use App\Http\Resources\Upload\UploadResource;
use App\Models\Upload;
use App\Repositories\UploadRepository;
use App\Services\UploadService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadController
 * @package App\Http\Controllers\Api
 */
class UploadController extends Controller
{


    /**
     * @param Upload $upload
     * @return JsonResource
     *
     */
    public function show(Upload $upload)
    {
        return new UploadResource($upload);
    }

    /**
     * Upload a file to S3 and store it's info in DB
     *
     * @param StoreUploadRequest $request
     * @return UploadResource
     */
    protected function store(StoreUploadRequest $request): UploadResource
    {

        $file = $request->file('file');
        $path = Storage::disk('s3')->putFile('temp', $file);

        $input = [
            'extension' => $file->extension(),
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $path
        ];

        $upload = UploadService::create($input);

        return new UploadResource($upload);
    }
}
