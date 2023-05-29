<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
