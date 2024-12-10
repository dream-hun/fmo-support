<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MalnutritionSupport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'malnutrition_id',
        'package_reception_date',
    ];

    public function malnutrition(): BelongsTo
    {
        return $this->belongsTo(Malnutrition::class);
    }

    protected function casts(): array
    {
        return [
            'package_reception_date' => 'date',
        ];
    }
}
