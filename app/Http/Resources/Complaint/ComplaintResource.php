<?php

namespace App\Http\Resources\Complaint;

use App\Http\Resources\Upload\UploadResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'victim' => $this->victim,
            'complaint_type' => $this->complaint_type,
            'name' => $this->name,
            'location_id' => $this->location_id,
            'location_name' => $this->location_name,
            'location_to_id' => $this->location_to_id,
            'location_to_name' => $this->location_to_name,
            'has_proof' => $this->has_proof,
            'uploads' => UploadResource::collection($this->uploads),

            'register_number' => $this->register_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
