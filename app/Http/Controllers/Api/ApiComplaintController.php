<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Http\Resources\ComplaintResource;
use Illuminate\Support\Facades\Validator;

class ApiComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::get();
        if ($complaints->count() > 0) {
            return ComplaintResource::collection($complaints);
        } else {
            return response()->json(['message' => 'No complaints found'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'number' => 'string|max:255',
            'description' => 'required|string',
            'status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $complaint = Complaint::create([
            'name' => $request->name,
            'number' => $request->number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Complaint created successfully', 'data' => new ComplaintResource($complaint)], 201);
    }

    public function show(Complaint $complaint)
    {
        return new ComplaintResource($complaint);
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'number' => 'string|max:255',
            'description' => 'string',
            'status' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $complaint->update([
            'name' => $request->name,
            'number' => $request->number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Complaint updated successfully', 'data' => new ComplaintResource($complaint)], 201);
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return response()->json(['message' => 'Complaint deleted successfully'], 200);
    }
}
