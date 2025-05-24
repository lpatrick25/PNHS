<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_lrn',
        'adviser_id',
        'grade_level',
        'school_year',
        'section',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_lrn', 'student_lrn');
    }
}
