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
            'attendance_status' => $this->attendanceStatus(),
            'exemption_status' => $this->exemptionStatus(),
            // 'exemption_proof_status' => $this->exemptionProofStatus(),
            'classroom' => new ClassroomResource($this->classroom),
        ];
    }

    // public function exemptionProofStatus()
    // {
    //     if ($this->attendance_status == AttendanceStatusEnum::Absent()) {
    //         if ($this->exemption_status == ExemptionStatusEnum::ExemptionNeeded()) {
    //             return 'Exemption proof not submited yet.';
    //         }

    //         return 'Exemption proof submitted.';
    //     }

    //     return null;
    // }

    public function attendanceStatus()
    {
        if ($this->attendance_status == AttendanceStatusEnum::Present()) {
            return AttendanceStatusEnum::Present()->label;
        }

        return AttendanceStatusEnum::Absent()->label;
    }

    public function exemptionStatus()
    {
        if ($this->exemption_status == ExemptionStatusEnum::ExemptionSubmitted()) {
            return ExemptionStatusEnum::ExemptionSubmitted()->label;
        }

        return ExemptionStatusEnum::ExemptionNeeded()->label;
    }
}
