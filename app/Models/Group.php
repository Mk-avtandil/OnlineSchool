<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'start_time',
        'end_time',
    ];

    public function students(): belongsToMany
    {
        return $this->belongsToMany(Student::class, 'group_student');
    }
    public function teachers(): belongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'group_teacher');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
