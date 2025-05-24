<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;

    protected $primaryKey = 'adviser_id';

    protected $fillable = [
        'teacher_id',
        'grade_level',
        'section',
        'school_year'
    ];
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            StudentStatus::class,
            'adviser_id', // Foreign key on StudentStatus table
            'student_lrn', // Foreign key on Students table
            'adviser_id', // Local key on Advisers table
            'student_lrn'  // Local key on StudentStatus table
        );
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'adviser_id', 'adviser_id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }
}
