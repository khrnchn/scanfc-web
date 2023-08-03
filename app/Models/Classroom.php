<?php

namespace App\Models;

use App\Enums\ClassTypeEnum;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'section_id',
        'venue_id',
        'name',
        'type',
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

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
