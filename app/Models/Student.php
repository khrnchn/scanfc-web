<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'matrix_id',
        'nfc_tag',
        'user_id',
        'faculty_id',
        'is_active',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
