<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'code', 'faculty_id', 'image_path'];

    protected $searchableFields = ['*'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class);
    }
}
