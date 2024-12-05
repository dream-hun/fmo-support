<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZamukaSupport extends Model
{
    use SoftDeletes;

    protected $casts = [
        'support_given' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'zamuka_id',
        'support_given',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function zamuka(): BelongsTo
    {
        return $this->belongsTo(Zamuka::class);
    }
}
