<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Resources\ActivityResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class ApiActivityController extends Controller
{

    public function index()
    {
        $activities = Activity::get();
        if ($activities->count() > 0) {
            return ActivityResource::collection($activities);
        } else {
            return response()->json(['message' => 'No activities found'], 200);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'required|string',
            'activity_type_id' => 'required|exists:activity_types,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $activity = Activity::create([
            'title' => $request->title,
            'activity_date' => $request->activity_date,
            'description' => $request->description,
            'activity_type_id' => $request->activity_type_id,
        ]);

        return response()->json(['message' => 'Activity created successfully', 'data' => new ActivityResource($activity)], 201);
    }


    public function show(Activity $activity)
    {
        return new ActivityResource($activity);
    }


    public function update(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'required|string',
            'activity_type_id' => 'required|exists:activity_types,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $activity->update([
            'title' => $request->title,
            'activity_date' => $request->activity_date,
            'description' => $request->description,
            'activity_type_id' => $request->activity_type_id,
        ]);

        return response()->json(['message' => 'Activity updated successfully', 'data' => new ActivityResource($activity)], 201);
    }


    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json(['message' => 'Activity deleted successfully'], 200);
    }
}


