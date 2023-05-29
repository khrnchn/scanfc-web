<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['staff_id', 'user_id', 'faculty_id'];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
