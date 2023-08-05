<?php

namespace App\Http\Resources;

use App\Enums\AttendanceStatusEnum;
use App\Enums\ClassTypeEnum;
use App\Models\Attendance;
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
            "section_name" => $this->section->name,
            "venue_name" => $this->venue->name,
            "classroom_name" => $this->name,
            "classroom_type" => $this->type,
            "start_at" => $this->start_at->format('Y-m-d H:i:s'),
            "end_at" => $this->end_at->format('Y-m-d H:i:s'),

            'attendance_status' => $this->getAttendanceStatus(),

            'section' => new SectionResource($this->section),

        ];
    }

    public function getAttendanceStatus()
    {
        $status = Attendance::where('classroom_id', $this->id)->value('attendance_status');

        if ($status === null) {
            return AttendanceStatusEnum::Error()->label;
        }

        if ($status == AttendanceStatusEnum::Present()) {
            return AttendanceStatusEnum::Present()->label;
        }

        return AttendanceStatusEnum::Absent()->label;
    }
}
