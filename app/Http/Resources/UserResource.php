<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "faculty_id" => $this->faculty_id,
            "phone_no" => $this->phone_no,
            "matrix_id" => $this->student->matrix_id,
            "access_token" => $this->when($this->id == auth()->id(), function () {
                return $this->accessToken;
            }),
        ];
    }
}
