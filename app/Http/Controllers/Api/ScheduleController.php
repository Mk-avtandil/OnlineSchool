<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleCreateRequest;
use App\Http\Resources\ScheduleCollection;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(): ScheduleCollection
    {
        $schedule = Schedule::all();

        return new ScheduleCollection($schedule);
    }

    public function store(ScheduleCreateRequest $request): JsonResponse
    {
        Schedule::create([
            'course' => $request->course,
            'group' => $request->group,
            'teacher' => $request->teacher,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json(['message' => 'Schedule created successfully!'], 201);
    }

    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();

            return response()->json(['message' => 'Schedule deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete schedule",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
