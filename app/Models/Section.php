<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['subject_id', 'lecturer_id', 'name'];

    protected $searchableFields = ['*'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
}
