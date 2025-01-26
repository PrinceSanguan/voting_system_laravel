<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class votingcandidate extends Model
{
    use HasFactory;

    public $timestamp = true;

    protected $table = 'votingcandidates';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'partylist',
        'position',
        'organization',
        'election_title',
        'election_year',
        'candidate_image',
        'cert_of_candidacy',
        'vote'
    ];
}
