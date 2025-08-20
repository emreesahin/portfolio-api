<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserProfileController;


Route::get('/test', function () {
    return response()->json(['message' => 'Test route']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// PUBLIC PROJECT ROUTES
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

//PUBLIC CONTACT ROUTES
Route::post('/contacts', [ContactController::class, 'store']);

//PUBLIC CATEGORY ROUTES
Route::get('/categories', [CategoryController::class, 'index']);

// PUBLIC USER PROFILE ROUTES
Route::get('/profile', [UserProfileController::class, 'public']);



// ADMIN  ROUTES
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // ADMIN PROJECT ROUTES
    Route::post('admin/projects', [ProjectController::class, 'store']);
    Route::put('admin/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('admin/projects/{project}', [ProjectController::class, 'destroy']);
    Route::post('admin/projects/{project}/cover', [ProjectController::class, 'uploadCover']);
    Route::post('admin/projects/{project}/gallery', [ProjectController::class, 'uploadGallery']);

    // ADMIN CONTACT ROUTES
    Route::get('admin/contacts', [ContactController::class, 'index']);

    // ADMIN CATEGORY ROUTES
    Route::post('admin/categories', [CategoryController::class, 'store']);
    Route::put('admin/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy']);

    // ADMIN USER PROFILE ROUTES
    Route::get('/me', [UserProfileController::class, 'show']);
    Route::put('/me', [UserProfileController::class, 'update']);
});
