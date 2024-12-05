<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zamuka extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'head_of_household_name',
        'household_id_number',
        'spouse_name',
        'spouse_id_number',
        'sector',
        'cell',
        'village',
        'house_hold_phone',
        'family_size',
        'main_source_of_income',
        'entrance_year',
    ];
}
