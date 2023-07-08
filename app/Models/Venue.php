<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'code'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
