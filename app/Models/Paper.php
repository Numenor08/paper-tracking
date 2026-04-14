<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Paper extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $fillable = [
        'title',
        'status',
        'abstract',
        'publication',
        'note',
        'created_by',
        'publication_index_id',
        'paper_media_id',
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
            ->withPivot('role')
            ->withTimestamps();
    }

    public function contributorPapers(): HasMany
    {
        return $this->hasMany(ContributorPaper::class, 'paper_id');
    }

    public function paperMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'paper_media_id');
    }
}
