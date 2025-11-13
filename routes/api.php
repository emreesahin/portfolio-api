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
| Public ve admin erişimlerini ayrı gruplar halinde toplar.
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
// 🙋 PROFILE
// ===========================
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'me']);


// ===========================
// 📁 PUBLIC CMS ROUTES
// ===========================

// Home content (tek satır yapı)
Route::get('/content', [ContentController::class, 'show']);

// About page (tek satır JSON yapı)
Route::get('/about', [AboutController::class, 'show']);

// Contact page içeriği (JSON yapı)
Route::get('/contact-content', [ContactController::class, 'showContent']);

// Contact form submission
Route::post('/contact', [ContactController::class, 'storeMessage']);


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
// 🔒 ADMIN (auth:sanctum + role:admin)
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

    // ✅ Content (home page text)
    Route::put('/content', [ContentController::class, 'update']);

    // ✅ About
    Route::put('/about', [AboutController::class, 'update']);

    // ✅ Messages (iletişim form kayıtları)
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
});

