<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'section_name' => $this->name,
            'subject_name' => $this->subject->name,
            'lecturer_name' => $this->lecturer->user->name,
            'subject' => new SubjectResource($this->subject),
        ];
    }
}
