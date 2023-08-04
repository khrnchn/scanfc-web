<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'faculty_name' => $this->faculty->name,
            'faculty_code' => $this->faculty->code,
        ];
    }
}
