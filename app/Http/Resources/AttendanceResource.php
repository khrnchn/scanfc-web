<?php

namespace App\Http\Resources;

use App\Enums\AttendanceStatusEnum;
use App\Enums\ExemptionStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 */
class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attendance_status' => $this->attendance_status,
            'exemption_status' => $this->exemption_status,
            'exemption_proof_status' => $this->getExemptionProofStatus(),
            'classroom' => new ClassroomResource($this->classroom),
        ];
    }

    private function getExemptionProofStatus()
    {
        if ($this->attendance_status == AttendanceStatusEnum::Absent()) {
            if ($this->exemption_status == ExemptionStatusEnum::ExemptionSubmitted()) {
                return ExemptionStatusEnum::ExemptionSubmitted()->label;
            } else {
                return ExemptionStatusEnum::ExemptionNeeded()->label;
            }
        }

        return null;
    }
}
