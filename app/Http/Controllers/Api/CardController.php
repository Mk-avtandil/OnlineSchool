<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardCreateRequest;
use App\Models\CreditCard;
use Illuminate\Http\JsonResponse;

class CardController extends Controller {

    public function store(CardCreateRequest $request): JsonResponse
    {
        try {
            $student = auth()->user()->student;

            CreditCard::Create([
                'student_id' => $student->id,
                'card_number' => $request->get('card_number'),
                'card_type' => $request->get('card_type'),
                'cvv' => $request->get('cvv'),
                'sum' => $request->get('sum'),
            ]);

            return response()->json(['message' => 'Credit card created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create card', 'error' => $e->getMessage()], 500);
        }
    }
}



