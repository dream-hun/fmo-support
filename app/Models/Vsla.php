<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vsla extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'representative_name',
        'representative_id',
        'representative_phone',
        'district',
        'sector',
        'cell',
        'village',
        'entrance_year',
        'mou_sign_date',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function creditTopUps(): HasMany
    {
        return $this->hasMany(CreditTopUp::class, 'vsla_id');
    }
}
