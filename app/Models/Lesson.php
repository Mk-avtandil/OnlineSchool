<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use InteractsWithMedia, hasFactory;

    protected $fillable = [
        'published',
        'title',
        'description',
        'course_id',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class);
    }

    public function addFiles($files)
    {
        foreach ($files as $file) {
            $this->addMedia($file)
                ->toMediaCollection('lesson_files');
        }
    }

    public function getFiles()
    {
        return $this->getMedia('lesson_files');
    }
}
