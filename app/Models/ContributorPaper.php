<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributorPaper extends Model
{
    public const ROLE_OPTIONS = [
        'LEAD-AUTHOR' => 'LEAD-AUTHOR',
        'CORRESPONDING-AUTHOR' => 'CORRESPONDING-AUTHOR',
        'CO-AUTHOR' => 'CO-AUTHOR',
    ];

    protected $table = 'contributor_paper';

    protected $fillable = [
        'contributor_id',
        'paper_id',
        'role',
    ];

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(Contributor::class, 'contributor_id');
    }

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }
}
