<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditTopUp extends Model
{
    use SoftDeletes;

    public function vsla(): BelongsTo
    {
        return $this->belongsTo(Vsla::class);
    }

    protected function casts(): array
    {
        return [
            'done_at' => 'date',
        ];
    }
}
