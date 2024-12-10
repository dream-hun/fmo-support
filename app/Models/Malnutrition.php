<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Malnutrition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'age_or_months',
        'associated_health_center',
        'sector',
        'cell',
        'village',
        'father_name',
        'mother_name',
        'home_phone_number',
        'entry_muac',
        'current_muac',
        'status',
    ];

    public function malnutritionSupports(): HasMany
    {
        return $this->hasMany(MalnutritionSupport::class, 'malnutrition_id');
    }
}
