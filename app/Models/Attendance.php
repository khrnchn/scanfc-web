<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['student_id', 'classroom_id', 'status'];

    protected $searchableFields = ['*'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
