<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrgentSupport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'urgent_id',
        'support_received',
        'done_at',
    ];

    public function urgent(): BelongsTo
    {
        return $this->belongsTo(Urgent::class);
    }

    protected function casts(): array
    {
        return [
            'done_at' => 'date',
        ];
    }
}
