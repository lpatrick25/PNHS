<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_lrn';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'student_lrn',
        'user_id',
        'rfid_no',
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'province_code',
        'municipality_code',
        'brgy_code',
        'zip_code',
        'religion',
        'birthday',
        'sex',
        'disability',
        'address_ifboarding',
        'email',
        'parent_contact',
        'contact',
        'mother_firstname',
        'mother_middlename',
        'mother_lastname',
        'mother_address',
        'father_firstname',
        'father_middlename',
        'father_lastname',
        'father_suffix',
        'father_address',
        'guardian',
        'guardian_address',
        'image',
    ];

    public function studentStatuses() {
        return $this->hasMany(StudentStatus::class, 'student_lrn', 'student_lrn');
    }
}
