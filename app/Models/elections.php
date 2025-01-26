<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elections extends Model
{
    use HasFactory;

    public $timestamp = true;
    protected $table = 'elections';
    protected $fillable = [

        'department',
        'election_title',
        'tbl_year',
        'tbl_date',
        'start_time',
        'end_time',
        'status',
        'required_partylist'

    ];
}
