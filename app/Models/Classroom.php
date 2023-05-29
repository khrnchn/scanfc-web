<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'subject_id',
        'section_id',
        'lecturer_id',
        'name',
        'start_at',
        'end_at',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
