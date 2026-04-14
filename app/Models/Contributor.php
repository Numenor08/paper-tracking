<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'full_name',
        'email',
        'affiliation',
        'phone_number',
        'address',
    ];

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'contributor_paper')
            ->withPivot('roles')
            ->withTimestamps();
    }
}
