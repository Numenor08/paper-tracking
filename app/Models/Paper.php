<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paper extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'status',
        'abstract',
        'publication',
        'note',
        'created_by',
        'publication_index_id',
    ];

    public function index(): BelongsTo
    {
        return $this->belongsTo(PublicationIndex::class, 'publication_index_id');
    }

    public function urlAttachment(): HasMany
    {
        return $this->hasMany(UrlAttachment::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(Contributor::class, 'contributor_paper')
            ->withPivot('roles')
            ->withTimestamps();
    }
}
