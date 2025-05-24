<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'student_lrn',
        'subject_listing',
        'school_year',
        'attendance_date',
        'status',
        'remarks'
    ];
}
