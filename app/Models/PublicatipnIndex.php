<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PublicationIndex extends Model
{
    protected $fillable = [
        'name',
    ];

    public function paper(): HasMany
    {
        return $this->hasMany(Paper::class);
    }
}
