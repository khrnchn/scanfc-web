<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'matrix_id' => $this->matrix_id,
            'nfc_tag' => $this->nfc_tag,
            'name' => $this->user->name,
            'faculty' => $this->faculty->name,
            'facultyCode' => $this->faculty->code,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
