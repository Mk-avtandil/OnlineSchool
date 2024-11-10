<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'phone',
        'email',
    ];

    public function groups(): belongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_teacher');

    }
}
