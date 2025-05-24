<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'teacher_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'teacher_id',
        'user_id',
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
        'email',
        'contact',
        'civil_status',
        'image',
    ];

    public function advisories()
    {
        return $this->hasMany(Adviser::class, 'teacher_id', 'teacher_id');
    }
}
