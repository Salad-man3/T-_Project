<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Resources\ActivityResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;

class ApiActivityController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query('limit', null);

        $query = Activity::with('photos')->latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $activities = $query->get();

        if ($activities->count() > 0) {
            return ActivityResource::collection($activities);
        } else {
            return response()->json(['message' => 'No activities found'], 200);
        }
    }

    public function store(Request $request)
    {
        Log::info('Received request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activity_type_id' => 'required|exists:activity_types,id',
            'activity_date' => 'required|date',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed:', ['errors' => $validator->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $activity = Activity::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'activity_type_id' => $request->input('activity_type_id'),
                'activity_date' => $request->input('activity_date'),
            ]);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $image) {
                    Log::info('Photo found in request');
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $image_name);

                    $photo = new Photo([
                        'photoable_type' => Activity::class,
                        'photoable_id' => $activity->id,
                        'photo_url' => asset('images/' . $image_name)
                    ]);
                    $activity->photos()->save($photo);
                    Log::info('Photo saved:', ['photo_url' => $photo->photo_url]);
                }
            } else {
                Log::info('No photos found in request');
            }

            $activity->load('photos');

            return response()->json(['message' => 'Activity created successfully', 'activity' => new ActivityResource($activity)], 201);
        } catch (\Exception $e) {
            Log::error('Error creating activity: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating activity', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Activity $activity)
    {
        return new ActivityResource($activity->load('photos'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'activity_type_id' => 'sometimes|required|exists:activity_types,id',
            'activity_date' => 'sometimes|required|date',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $activity->update([
            'title' => $request->input('title', $activity->title),
            'description' => $request->input('description', $activity->description),
            'activity_type_id' => $request->input('activity_type_id', $activity->activity_type_id),
            'activity_date' => $request->input('activity_date', $activity->activity_date),
        ]);

        if ($request->hasFile('photos')) {
            // Remove existing photos
            $activity->photos()->delete();

            foreach ($request->file('photos') as $image) {
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $image_name);

                $photo = new Photo([
                    'photoable_type' => Activity::class,
                    'photoable_id' => $activity->id,
                    'photo_url' => asset('images/' . $image_name)
                ]);
                $activity->photos()->save($photo);
            }
        } else {
            $activity->photos()->delete();
        }

        return response()->json(['message' => 'Activity updated successfully', 'activity' => new ActivityResource($activity->fresh()->load('photos'))], 200);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json(['message' => 'Activity deleted successfully'], 200);
    }
}


