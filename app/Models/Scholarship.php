<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'national_id_number',
        'district',
        'sector',
        'cell',
        'village',
        'telephone',
        'email',
        'university_attended',
        'faculty',
        'program_duration',
        'year_of_entrance',
        'intake',
        'school_contact',
        'status',
    ];
}
