<?php

namespace App\Http\Resources\Complaint;

use App\Constants\ComplaintConstant;
use App\Http\Resources\Upload\UploadResource;
use Carbon\Carbon;
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
            'type' => $this->type,
            'type_label' => ComplaintConstant::typeLabels()[$this->type],
            'name' => $this->name,
            'location_id' => $this->location_id,
            'location_name' => $this->location_name,
            'location_to_id' => $this->location_to_id,
            'location_to_name' => $this->location_to_name,
            'proof_type' => $this->proof_type,
            'details' => $this->details,
            'uploads' => UploadResource::collection($this->uploads),

            'register_number' => $this->register_number,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
            'updated_at' =>  Carbon::parse($this->updated_at)->format('Y-m-d H:i'),
        ];
    }
}
