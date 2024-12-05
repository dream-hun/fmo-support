<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolFeeding extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'grade',
        'school',
        'district',
        'sector',
        'cell',
        'village',
        'father_name',
        'mother_name',
        'gender',
    ];

    public function schoolFeedingPayments(): HasMany
    {
        return $this->hasMany(SchoolFeedingPayment::class, 'school_feeding_id');
    }
}
