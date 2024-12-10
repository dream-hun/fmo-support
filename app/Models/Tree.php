<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tree extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'national_id_number',
        'sector',
        'cell',
        'village',
        'phone',
    ];

    public function treeSupports(): HasMany
    {
        return $this->hasMany(TreesSupport::class, 'tree_id');
    }
}
