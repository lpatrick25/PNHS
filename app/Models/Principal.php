<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    use HasFactory;

    protected $primaryKey = 'principal_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'principal_id',
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
}
