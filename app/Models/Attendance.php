<?php

namespace App\Models;

use App\Enums\AttendanceStatusEnum;
use App\Enums\ExemptionStatusEnum;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'classroom_id',
        'enrollment_id',
        'attendance_date',
        'attendance_status', 
        'exemption_status',  
        'exemption_file'     
    ];

    // protected $casts = [
    //     'attendance_status' => AttendanceStatusEnum::class, 
    //     'exemption_status' => ExemptionStatusEnum::class, 
    // ];

    protected $searchableFields = ['*'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
