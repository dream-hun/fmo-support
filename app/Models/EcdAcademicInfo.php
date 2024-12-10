<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EcdAcademicInfo extends Model
{
    protected $fillable = [
        'ecd_id',
        'academic_year',
        'status',
        'grade',
        'comment',
    ];

    public function ecd(): BelongsTo
    {
        return $this->belongsTo(Ecd::class);
    }
}
