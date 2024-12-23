<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditTopUp extends Model
{
    use SoftDeletes;

    protected $casts = [
        'done_at' => 'date:Y-m-d',
    ];

    public function vsla(): BelongsTo
    {
        return $this->belongsTo(Vsla::class);
    }
}
