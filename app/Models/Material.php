<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Material extends Model
{
    protected $fillable = ['lesson_id'];

    public function files(): morphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
