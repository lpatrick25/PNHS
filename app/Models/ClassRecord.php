<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'records_id';

    protected $fillable = [
        'records_name',
        'student_lrn',
        'subject_listing',
        'school_year',
        'total_score',
        'student_score',
        'records_type',
        'quarter'
    ];
}
