<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Portfolio API (Laravel 12 + Sanctum + Spatie Roles)
|--------------------------------------------------------------------------
*/

// 🧭 Base route
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Portfolio API 🚀',
        'version' => '1.0.0',
    ]);
});


// ===========================
// 🔐 AUTHENTICATION
// ===========================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// ===========================
// 🙋 PROFILE (Protected)
// ===========================
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'me']);


// ===========================
// 📁 PUBLIC CMS ROUTES
// ===========================

// Home content (public)
Route::get('/content', [ContentController::class, 'index']);

// About page content (public)
Route::get('/about', [AboutController::class, 'show']);

// Contact page content (public)
Route::get('/contact-content', [ContactController::class, 'showContent']);

// Contact form submission (USER MESSAGE SENDS)
Route::post('/contact', [MessageController::class, 'store']);


// ===========================
// 🧩 PUBLIC DATA (CATEGORIES & PROJECTS)
// ===========================

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);


// ===========================
// 🔒 ADMIN ROUTES
// ===========================
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // ✅ Category CRUD
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // ✅ Project CRUD
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    // ✅ Content (Home page)
    Route::put('/content', [ContentController::class, 'update']);

    // ✅ About page
    Route::put('/about', [AboutController::class, 'update']);

    // ✅ Contact Page Content
    Route::post('/contact-content', [ContactController::class, 'storeContent']);
    Route::delete('/contact-content', [ContactController::class, 'destroyContent']);

    // ✅ Messages (User submissions)
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
});
