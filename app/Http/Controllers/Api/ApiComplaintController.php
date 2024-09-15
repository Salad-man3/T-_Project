<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Http\Resources\ComplaintResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


class ApiComplaintController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query('limit', null);

        $query = Complaint::latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $complaints = $query->get();

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
        return response()->json(['message' => 'Complaint soft deleted successfully'], 200);
    }


    public function trashed()
    {
        $trashedComplaints = Complaint::onlyTrashed()->get();
        return ComplaintResource::collection($trashedComplaints);
    }


    public function restore($id)
    {
        $complaint = Complaint::withTrashed()->findOrFail($id);
        $complaint->restore();
        return response()->json(['message' => 'Complaint restored successfully'], 200);
    }


    public function forceDelete($id)
    {
        $complaint = Complaint::withTrashed()->findOrFail($id);
        $complaint->forceDelete();
        return response()->json(['message' => 'Complaint permanently deleted'], 200);
    }
}

