<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voters extends Model
{
    use HasFactory;

    public $timestamp = true;
    protected $fillable = [
        'email',
        'pin',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'course',
        'tbl_year',
        'year_lvl',
        'phone_number',
        'organization',
        'status',
        'voted',
        'otp'

    ];
}
