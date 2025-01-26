<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ballot extends Model
{
    use HasFactory;

    protected $table = 'ballots';

    public $timestamp = true;

    protected $fillable = [

        'fingerprint',
        'voted_candidates',
        'election_title',
        'election_year',
        'organization'

    ];
}
