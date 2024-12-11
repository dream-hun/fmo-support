<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarshipSupport extends Model
{
    protected $fillable = [
        'scholarship_id',
        'academic_year',
        'support',
        'comment',
    ];

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }

    protected $casts = [
        'support' => 'array',
    ];
}
