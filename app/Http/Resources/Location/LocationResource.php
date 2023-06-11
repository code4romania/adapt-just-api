<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'email' => $this->email,
            'county_iso' => $this->county_iso,
            'county_name' => $this->county_name,
            'county_label' => $this->county_label,
            'city_name' => $this->city_name,
            'city_label' => $this->city_label,
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }
}
