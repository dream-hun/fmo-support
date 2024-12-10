<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toolkit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'identification_number',
        'phone_number',
        'tvet_attended',
        'option',
        'level',
        'training_intake',
        'reception_date',
        'toolkit_received',
        'toolkit_cost',
        'subsidized_percent',
        'sector',
        'total',
    ];
}
