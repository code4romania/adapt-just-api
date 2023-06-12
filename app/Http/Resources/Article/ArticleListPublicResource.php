<?php

namespace App\Http\Resources\Article;

use App\Constants\ResourceConstant;
use App\Http\Resources\Upload\UploadResource;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ArticleListPublicResource extends JsonResource
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
            'short_content' => $this->short_content,
            'upload' => $this->upload_id ? new UploadResource($this->upload) : null,
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('Y-m-d H:i') : null
        ];
    }
}
