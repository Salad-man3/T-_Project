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

    public function index()
    {
        $news = News::get();
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
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $news = News::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'News created successfully', 'data' => new NewsResource($news)], 201);
    }


    public function show(News $news)
    {
        return new NewsResource($news);
    }


    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $news->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'News Updated successfully', 'data' => new NewsResource($news)], 201);
    }


    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'News deleted successfully'], 200);
    }
}

