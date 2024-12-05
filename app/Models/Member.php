<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vsla_id',
        'name',
        'gender',
        'id_number',
        'sector',
        'cell',
        'village',
        'mobile',
        'status',
        'notes',
    ];

    public function vsla(): BelongsTo
    {
        return $this->belongsTo(Vsla::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);

    }
}
