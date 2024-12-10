<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Musa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'head_of_family_name',
        'national_id',
        'total_family_members',
        'district',
        'sector',
        'cell',
        'village',
    ];

    public function supports(): HasMany
    {
        return $this->hasMany(MusaSupport::class);
    }
}
