<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;


class CategoryController extends Controller
{

    // Categories List
   public function index()
{
    try {
        $categories = Category::with('projects')->get();

        return CategoryResource::collection($categories)
            ->additional([
                'status' => true,
                'message' => 'Kategoriler başarıyla listelendi.'
            ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Kategoriler listelenemedi.',
            'errors' => $e->getMessage(),
        ], 500);
    }
}


    // Add New Category
    public function store(CategoryRequest $request) {
        try {
            $category = Category::create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Kategori başarıyla eklendi',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori eklenirken bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Category Update
    public function update(CategoryRequest $request, Category $category) {
        try {
            $category->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Kategori başarıyla güncellendi',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori güncellenirken bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Category Delete
    public function destroy(Category $category) {
        try {
            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Kategori başarıyla silindi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori silinirken bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
