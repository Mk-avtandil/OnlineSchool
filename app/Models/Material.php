<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['lesson_id'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
