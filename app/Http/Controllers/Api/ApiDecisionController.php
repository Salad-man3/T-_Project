<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Decision;
use App\Http\Resources\DecisionResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


class ApiDecisionController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query('limit', null);

        $query = Decision::latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $decisions = $query->get();

        if ($decisions->isEmpty()) {
            return response()->json(['message' => 'No decisions found'], 404);
        }

        return response()->json([
            'count' => $decisions->count(),
            'data' => DecisionResource::collection($decisions),
        ]);


    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decision_id' => 'required|integer',
            'decision_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $decision = Decision::create([
            'decision_id' => (int) $request->decision_id,
            'decision_date' => $request->decision_date,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Decision created successfully'], 201);
    }


    public function show(Decision $decision)
    {
        return new DecisionResource($decision);
    }

    public function update(Request $request, Decision $decision)
    {
        $validator = Validator::make($request->all(), [
            'decision_id' => 'required|integer',
            'decision_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $decision->update([
            'decision_id' => $request->decision_id,
            'decision_date' => $request->decision_date,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Decision updated successfully'], 201);
    }


    public function destroy(Decision $decision)
    {
        $decision->delete();
        return response()->json(['message' => 'Decision deleted successfully'], 200);
    }
}
