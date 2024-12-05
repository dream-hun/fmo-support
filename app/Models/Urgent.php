<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urgent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'national_id_number',
        'district',
        'sector',
        'cell',
        'village',
        'phone_number',
    ];

    public function supports(): HasMany
    {
        return $this->hasMany(UrgentSupport::class);
    }
}
