<?php

namespace App\Http\Resources\Upload;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mime' => $this->mime,
            'size' => $this->size,
            'path' => $this->path,
            'extension' => $this->extension,
            'dataUrl' => url(Storage::disk()->url($this->path)),
        ];
    }
}
