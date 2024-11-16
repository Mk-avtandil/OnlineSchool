<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Solution extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'answer',
        'student_id',
        'homework_id',
    ];

    public function homework(): belongsTo
    {
        return $this->belongsTo(Homework::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class);
    }

    public function addFiles($files)
    {
        foreach ($files as $file) {
            $this->addMedia($file)
                ->toMediaCollection('solution_files');
        }
    }

    public function getFiles()
    {
        return $this->getMedia('solution_files');
    }
}
