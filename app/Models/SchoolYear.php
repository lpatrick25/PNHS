<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $primaryKey = 'school_year_id';

    protected $fillable = ['school_year', 'start_date', 'end_date', 'current'];

    // Relationship to Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'school_year_id');
    }

    // Relationship to Advisers
    public function advisers()
    {
        return $this->hasMany(Adviser::class, 'school_year_id');
    }
}
