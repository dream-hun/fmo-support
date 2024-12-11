<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mvtc extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reg_no',
        'name',
        'gender',
        'dob',
        'student_id',
        'student_contact',
        'trade',
        'resident_district',
        'sector',
        'cell',
        'village',
        'education_level',
        'scholar_type',
        'intake',
        'graduation_date',
        'sponsor',
        'status',
    ];
}
