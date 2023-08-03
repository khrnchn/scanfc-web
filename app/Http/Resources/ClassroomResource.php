<?php

namespace App\Http\Resources;

use App\Enums\ClassTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "section_id" => $this->section->name,
            "venue_id" => $this->venue->name,
            "name" => $this->name,
            "type" => $this->type,
            "start_at" => $this->start_at->format('Y-m-d H:i:s'),
            "end_at" => $this->end_at->format('Y-m-d H:i:s'),
        ];
    }
}
