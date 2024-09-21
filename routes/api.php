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



Route::apiResource('news', ApiNewsController::class);
Route::apiResource('services', ApiServiceController::class);
Route::apiResource('service-categories', ApiServiceCategoryController::class);
Route::apiResource('activity', ApiActivityController::class);
Route::apiResource('activity-type', ApiActivityTypeController::class);
Route::apiResource('photo', ApiPhotoController::class);
Route::apiResource('decision', ApiDecisionController::class);
Route::apiResource('complaint', ApiComplaintController::class);

Route::get('complaints/trashed', [ApiComplaintController::class, 'trashed']);
Route::post('complaints/{id}/restore', [ApiComplaintController::class, 'restore']);
Route::delete('complaints/{id}/force', [ApiComplaintController::class, 'forceDelete']);

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

// Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
//     // Your protected admin API routes here
// });
