<?php

namespace App\Models;

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
        'attendance_status', // 'present' or 'absent'
        'exemption_status',  // 'no_exemption', 'exemption_needed', 'exemption_uploaded'
        'exemption_file'     // The file path or URL to the uploaded exemption file
    ];

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
