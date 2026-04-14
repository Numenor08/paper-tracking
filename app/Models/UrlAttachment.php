<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlAttachment extends Model
{
    protected $fillable = [
        'label',
        'url',
        'paper_id',
        'created_at',
        'updated_at',
    ];

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }
}
