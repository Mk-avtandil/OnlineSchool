<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'sum',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
