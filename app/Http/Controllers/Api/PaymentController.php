<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store($courseId)
    {
        $student = auth()->user()->student;

        $course = Course::findOrFail($courseId);

        $creditCard = $student->creditCard;

        if ($creditCard->sum < $course->price) {
            return response()->json(['error' => 'Insufficient funds on the credit card.'], 400);
        }

        $creditCard->sum -= $course->price;

        $creditCard->save();

        Payment::create([
            'sum' => $course->price,
            'course_id' => $courseId,
            'student_id' => $student->id,
        ]);

        return response()->json(['message' => 'Payment created successfully!'], 201);
    }
}