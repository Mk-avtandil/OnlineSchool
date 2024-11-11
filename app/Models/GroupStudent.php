<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupStudent extends Model
{
    protected $table = 'group_student';
    protected $fillable = ['group_id', 'student_id'];
}
