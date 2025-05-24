<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'subject_listing';

    protected $fillable = [
        'subject_code',
        'teacher_id',
        'school_year',
        'grade_level',
        'section',
    ];
}
