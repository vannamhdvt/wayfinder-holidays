<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnquiryResource extends JsonResource
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
            'tour_id' => $this->tour_id,
            'tour_name' => $this->tour?->name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'preferred_month' => $this->preferred_month,
            'message' => $this->message,
            'status' => $this->status->value,
            'created_at' => $this->created_at,
        ];
    }
}
