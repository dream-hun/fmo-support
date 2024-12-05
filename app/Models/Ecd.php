<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ecd extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'grade',
        'gender',
        'birthday',
        'academic_year',
        'district',
        'sector',
        'cell',
        'village',
        'father_name',
        'father_id_number',
        'mother_name',
        'home_phone_number',

    ];
}
