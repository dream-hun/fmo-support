<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MusaSupport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'musa_id',
        'support_given',
        'date_of_support',
    ];

    public function musa(): BelongsTo
    {
        return $this->belongsTo(Musa::class);
    }

    protected function casts(): array
    {
        return [
            'date_of_support' => 'date',
        ];
    }
}
