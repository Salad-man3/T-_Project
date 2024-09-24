<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiNewsController;
use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\Api\ApiServiceCategoryController;
use App\Http\Controllers\Api\ApiActivityController;
use App\Http\Controllers\Api\ApiActivityTypeController;
use App\Http\Controllers\Api\ApiPhotoController;
use App\Http\Controllers\Api\ApiComplaintController;
use App\Http\Controllers\Api\ApiDecisionController;

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CouncilMemberController;

Route::apiResource('council-members', CouncilMemberController::class);

Route::apiResource('news', ApiNewsController::class)->only(['index', 'show']);
Route::apiResource('services', ApiServiceController::class)->only(['index', 'show']);
Route::apiResource('service-categories', ApiServiceCategoryController::class)->only(['index', 'show']);
Route::apiResource('activity', ApiActivityController::class)->only(['index', 'show']);
Route::apiResource('activity-type', ApiActivityTypeController::class)->only(['index', 'show']);
Route::apiResource('photo', ApiPhotoController::class)->only(['index', 'show']);
Route::apiResource('decision', ApiDecisionController::class)->only(['index', 'show']);
Route::post('complaint', [ApiComplaintController::class, 'store']);

Route::get('complaint', [ApiComplaintController::class, 'index']);
Route::get('complaint/{complaint}', [ApiComplaintController::class, 'show']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('admin/login', [AdminController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('admin/logout', [AdminController::class, 'logout']);
    Route::get('admin/me', [AdminController::class, 'me']);
});
// Route::put('service-categories/{service-categories}', [ApiServiceCategoryController::class, 'update']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('news', [ApiNewsController::class, 'store']);
    Route::put('news/{news}', [ApiNewsController::class, 'update']);
    Route::delete('news/{news}', [ApiNewsController::class, 'destroy']);

    Route::post('services', [ApiServiceController::class, 'store']);
    Route::put('services/{services}', [ApiServiceController::class, 'update']);
    Route::delete('services/{services}', [ApiServiceController::class, 'destroy']);

    Route::post('service-categories', [ApiServiceCategoryController::class, 'store']);
    Route::put('service-categories/{service_category}', [ApiServiceCategoryController::class, 'update']);
    Route::delete('service-categories/{service_category}', [ApiServiceCategoryController::class, 'destroy']);

    Route::post('activity', [ApiActivityController::class, 'store']);
    Route::put('activity/{activity}', [ApiActivityController::class, 'update']);
    Route::delete('activity/{activity}', [ApiActivityController::class, 'destroy']);

    Route::post('activity-type', [ApiActivityTypeController::class, 'store']);
    Route::put('activity-type/{activity_type}', [ApiActivityTypeController::class, 'update']);
    Route::delete('activity-type/{activity_type}', [ApiActivityTypeController::class, 'destroy']);

    Route::post('decision', [ApiDecisionController::class, 'store']);
    Route::put('decision/{decision}', [ApiDecisionController::class, 'update']);
    Route::delete('decision/{decision}', [ApiDecisionController::class, 'destroy']);



    Route::put('complaint/{complaint}', [ApiComplaintController::class, 'update']);
    Route::delete('complaint/{complaint}', [ApiComplaintController::class, 'destroy']);

    // Soft delete routes for complaints
    Route::post('complaints/{id}/restore', [ApiComplaintController::class, 'restore']);
    Route::delete('complaints/{id}/force', [ApiComplaintController::class, 'forceDelete']);
    Route::get('complaints/trashed', [ApiComplaintController::class, 'trashed']);


    Route::post('complaints/{id}/restore', [ApiComplaintController::class, 'restore']);
    Route::delete('complaints/{id}/force', [ApiComplaintController::class, 'forceDelete']);
});
