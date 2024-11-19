<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'course',
        'group',
        'teacher',
        'start_time',
        'end_time',
    ];

}
