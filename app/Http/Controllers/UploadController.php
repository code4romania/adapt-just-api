<?php

namespace App\Http\Controllers;

use App\Http\Requests\Upload\StoreUploadRequest;
use App\Http\Resources\Upload\UploadResource;
use App\Models\Upload;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadController
 * @package App\Http\Controllers\Api
 */
class UploadController extends Controller
{


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

        $hashName = md5($upload->path . $upload->id);
        $upload->update(['hash_name' => $hashName]);

        return new UploadResource($upload);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function show($uploadHashName, Request $request)
    {

        if (! $request->hasValidSignature()) {
            abort(401);
        }
        $upload = Upload::where('hash_name', $uploadHashName)->firstOrFail();

        return response()->make(
            Storage::disk('s3')->get($upload->path),
            200,
            ['Content-Type' => $upload->mime]
        );
    }
}
