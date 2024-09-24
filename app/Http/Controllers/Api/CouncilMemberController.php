<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouncilMemberRequest;
use App\Http\Resources\CouncilMemberResource;
use App\Models\CouncilMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;

class CouncilMemberController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Fetching council members', ['request' => $request->all()]);

        $limit = $request->query('limit', null);
        $query = CouncilMember::with('photo')->latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $council_members = $query->get();

        if ($council_members->isEmpty()) {
            Log::info('No council members found');
            return response()->json(['message' => 'No council members found'], 404);
        }

        Log::info('Council members retrieved successfully', ['count' => $council_members->count()]);

        return response()->json([
            'count' => $council_members->count(),
            'data' => CouncilMemberResource::collection($council_members),
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Creating a new council member', ['request' => $request->all()]);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $council_member = CouncilMember::create([
                'name' => $request->input('name'),
            ]);

            Log::info('Council member created', ['id' => $council_member->id]);

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $image_name);

                $photo = new Photo([
                    'photoable_type' => CouncilMember::class,
                    'photoable_id' => $council_member->id,
                    'photo_url' => asset('images/' . $image_name)
                ]);
                $council_member->photo()->save($photo);
            }

            return response()->json(['message' => 'Council member created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating council member', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error creating council member', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(CouncilMember $council_member)
    {
        Log::info('Fetching council member', ['id' => $council_member->id]);
        return new CouncilMemberResource($council_member->load('photo'));
    }

    public function update(Request $request, CouncilMember $council_member)
    {
        Log::info('Updating council member', ['id' => $council_member->id, 'request' => $request->all()]);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $council_member->update([
            'name' => $request->input('name', $council_member->name),
        ]);

        if ($request->hasFile('photo')) {
            // Remove existing photo
            $council_member->photo()->delete();

            $image = $request->file('photo');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $image_name);

            $photo = new Photo([
                'photoable_type' => CouncilMember::class,
                'photoable_id' => $council_member->id,
                'photo_url' => asset('images/' . $image_name)
            ]);
            $council_member->photo()->save($photo);
        } else {
            $council_member->photo()->delete();
        }

        return response()->json(['message' => 'Council member updated successfully'], 200);
    }

    public function destroy(CouncilMember $council_member)
    {
        $council_member->delete();
        return response()->json(['message' => 'Council member deleted successfully'], 200);
    }
}
