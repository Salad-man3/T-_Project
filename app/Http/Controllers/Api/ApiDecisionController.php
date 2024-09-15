<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Decision;
use App\Http\Resources\DecisionResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


/**
 * @OA\Get(
 *     path="/api/decision",
 *     summary="Get a list of decisions",
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="Limit the number of results",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Successful operation")
 * )
 */
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

        if ($decisions->count() > 0) {
            return DecisionResource::collection($decisions);
        } else {
            return response()->json(['message' => 'No decisions found'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decision_id' => 'required|string|max:255',
            'decision_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $decision = Decision::create([
            'decision_id' => $request->decision_id,
            'decision_date' => $request->decision_date,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Decision created successfully', 'data' => new DecisionResource($decision)], 201);
    }


    public function show(Decision $decision)
    {
        return new DecisionResource($decision);
    }

    public function update(Request $request, Decision $decision)
    {
        $validator = Validator::make($request->all(), [
            'decision_id' => 'required|string|max:255',
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

        return response()->json(['message' => 'Decision updated successfully', 'data' => new DecisionResource($decision)], 201);
    }


    public function destroy(Decision $decision)
    {
        $decision->delete();
        return response()->json(['message' => 'Decision deleted successfully'], 200);
    }
}
