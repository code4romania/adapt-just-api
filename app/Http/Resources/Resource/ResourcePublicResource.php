<?php

namespace App\Http\Resources\Resource;

use App\Http\Resources\Upload\UploadResource;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourcePublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'content' => UploadService::parseHtmlContent($this->content),
            'short_content' => $this->short_content,
            'upload' => $this->upload_id ? new UploadResource($this->upload) : null,
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('Y-m-d H:i') : null
        ];
    }
}
