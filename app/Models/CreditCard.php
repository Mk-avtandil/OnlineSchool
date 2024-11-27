<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCard extends Model
{
    protected $fillable = [
        'student_id',
        'card_number',
        'card_type',
        'cvv',
        'sum',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
