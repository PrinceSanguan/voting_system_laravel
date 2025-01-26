<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organizations extends Model
{
    use HasFactory;

    public $timestamp = true;

    protected $fillable = [

        'organization',
        'program_course',
        'Status'

    ];
}
