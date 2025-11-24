<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'owner_id',
        'notes',
    ];

    /**
     * Get the owner (client) that owns the pet.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
