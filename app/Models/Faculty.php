<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
