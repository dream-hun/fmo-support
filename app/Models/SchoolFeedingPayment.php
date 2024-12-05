<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolFeedingPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_feeding_id',
        'academic_year',
        'trimester',
        'amount',
        'status',
    ];

    public function schoolFeeding(): BelongsTo
    {
        return $this->belongsTo(SchoolFeeding::class);
    }
}
