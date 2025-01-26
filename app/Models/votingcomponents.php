<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class votingcomponents extends Model
{
    use HasFactory;

    public $timestamp = true;
    protected $fillable = [
        'candidate',
        'partylist',
        'position',
        'maxvote',
        'organization',
        'status'
    ];
}
