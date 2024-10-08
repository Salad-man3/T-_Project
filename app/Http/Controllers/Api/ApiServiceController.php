<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


class ApiServiceController extends Controller
{

    public function index(Request $request)
    {
        $limit = $request->query('limit', null);
        $serviceCategoryId = $request->query('service_category_id', null);

        $query = Service::latest();

        if ($serviceCategoryId) {
            $query->where('service_category_id', $serviceCategoryId);
        }

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $services = $query->get();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'No activities found'], 404);
        }


        return response()->json([
            'count' => $services->count(),
            'data' => ServiceResource::collection($services),
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|exists:service_categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $service = Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'service_category_id'=> $request->service_category_id,
        ]);
        return response()->json(['message' => 'Service created successfully'], 201);
    }


    public function show(Service $service)
    {
        return new ServiceResource($service);
    }


    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service_category_id' => 'required|exists:service_categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'service_category_id'=> $request->service_category_id,
        ]);

        return response()->json(['message' => 'Service updated successfully'], 201);

    }


    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}

