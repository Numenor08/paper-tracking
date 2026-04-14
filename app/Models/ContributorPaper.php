<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContributorPaper extends Model
{
    protected $fillable = [
        'contributor_id',
        'paper_id',
        'role',
    ];

    public function contributor(): HasOne
    {
        return $this->hasOne(Contributor::class, 'id', 'contributor_id');
    }

    public function paper(): HasOne
    {
        return $this->hasOne(Paper::class, 'id', 'paper_id');
    }
}
