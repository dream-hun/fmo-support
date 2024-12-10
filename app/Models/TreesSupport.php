<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreesSupport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'avocadoes',
        'mangoes',
        'oranges',
        'papaya',
        'tree_id',
    ];

    public function tree(): BelongsTo
    {
        return $this->belongsTo(Tree::class);
    }
}
