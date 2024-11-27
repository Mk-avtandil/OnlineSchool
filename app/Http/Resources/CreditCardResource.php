<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'card_number' => $this->card_number,
            'card_type' => $this->card_type,
            'cvv' => $this->cvv,
            'sum' => $this->sum,
        ];
    }
}
