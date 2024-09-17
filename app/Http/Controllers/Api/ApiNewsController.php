<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


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
            'photos.*' => 'url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('photos')) {
            foreach ($request->photos as $photoUrl) {
                $news->photos()->create(['photo_url' => $photoUrl]);
            }
        }

        $news->load('photos');

        return response()->json(['message' => 'News created successfully'], 201);
    }


    public function show(News $news)
    {
        return new NewsResource($news->load('photos'));
    }


    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $news->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $news->load('photos');


        return response()->json(['message' => 'News Updated successfully'], 201);
    }


    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'News deleted successfully'], 200);
    }
}

