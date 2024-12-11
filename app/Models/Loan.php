<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'member_id',
        'vsla_id',
        'done_at',
        'amount',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function vsla(): BelongsTo
    {
        return $this->belongsTo(Vsla::class);
    }

    protected $casts = [
        'done_at' => 'date',
    ];
}
