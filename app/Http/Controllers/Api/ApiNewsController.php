<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;

class ApiNewsController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query('limit', null);

        $query = News::with('photos')->latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $news = $query->get();

        if ($news->count() > 0) {
            return NewsResource::collection($news);
        } else {
            return response()->json(['message' => 'No news found'], 200);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $news = News::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $image) {
                    Log::info('Photo found in request');
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $image_name);

                    $photo = new Photo([
                        'photoable_type' => News::class,
                        'photoable_id' => $news->id,
                        'photo_url' => asset('images/' . $image_name)
                    ]);
                    $news->photos()->save($photo);
                    Log::info('Photo saved:', ['photo_url' => $photo->photo_url]);
                }
            } else {
                Log::info('No photos found in request');
            }

            $news->load('photos');

            return response()->json(['message' => 'News created successfully', 'news' => new NewsResource($news)], 201);
        } catch (\Exception $e) {
            Log::error('Error creating news: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating news', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(News $news)
    {
        return new NewsResource($news->load('photos'));
    }

    public function update(NewsRequest $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $news->update([
            'title' => $request->input('title', $news->title),
            'description' => $request->input('description', $news->description),
        ]);

        if ($request->hasFile('photos')) {
            // Remove existing photos
            $news->photos()->delete();

            foreach ($request->file('photos') as $image) {
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $image_name);

                $photo = new Photo([
                    'photoable_type' => News::class,
                    'photoable_id' => $news->id,
                    'photo_url' => asset('images/' . $image_name)
                ]);
                $news->photos()->save($photo);
            }
        } else {
            $news->photos()->delete();
        }

        return response()->json(['message' => 'News updated successfully', 'news' => new NewsResource($news->fresh()->load('photos'))], 200);
    }


    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'News deleted successfully'], 200);
    }
}
