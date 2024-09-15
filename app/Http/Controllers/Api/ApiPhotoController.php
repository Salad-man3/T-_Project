<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Http\Resources\PhotoResource;
use Illuminate\Support\Facades\Validator;

class ApiPhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::get();
        if ($photos->count() > 0) {
            return PhotoResource::collection($photos);
        } else {
            return response()->json(['message' => 'No photos found'], 200);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo_url' => 'required|string|max:255',
            'photoable_id' => 'required|string|max:255',
            'photoable_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $photo = Photo::create([
            'photo_url' => $request->photo_url,
            'photoable_id' => $request->photoable_id,
            'photoable_type' => $request->photoable_type,
        ]);

        return response()->json(['message' => 'Photo created successfully', 'data' => new PhotoResource($photo)], 201);
    }

    public function show(Photo $photo)
    {
        return new PhotoResource($photo);
    }

    public function update(Request $request, Photo $photo)
    {
        $validator = Validator::make($request->all(), [
            'photo_url' => 'required|string|max:255',
            'photoable_id' => 'required|string|max:255',
            'photoable_type' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $photo->update([
            'photo_url' => $request->photo_url,
            'photoable_id' => $request->photoable_id,
            'photoable_type' => $request->photoable_type,
        ]);

        return response()->json(['message' => 'Photo updated successfully', 'data' => new PhotoResource($photo)], 201);
    }
    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json(['message' => 'Photo deleted successfully'], 200);
    }


}
