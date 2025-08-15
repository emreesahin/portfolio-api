<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;

Route::get('/test', function () {
    return response()->json(['message' => 'Test route']);
});

// token gerektirir
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// PUBLIC PROJECT ROUTES
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

// ADMIN PROJECT ROUTES
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('admin/projects', [ProjectController::class, 'store']);
    Route::put('admin/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('admin/projects/{project}', [ProjectController::class, 'destroy']);
    Route::post('admin/projects/{project}/cover', [ProjectController::class, 'uploadCover']);
    Route::post('admin/projects/{project}/gallery', [ProjectController::class, 'uploadGallery']);
});
