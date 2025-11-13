<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::with('projects')->get();
            return response()->json($categories, 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error fetching categories',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = Category::create($validated);
            return response()->json([
                'message' => 'Category created successfully',
                'data' =>$category], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error creating category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $category = Category::with('projects')->findOrFail($id);
            return response()->json($category, 200);

        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error fetching category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);
            
            $category = Category::findOrFail($id);
            $category->update($validated);
            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $category], 200);
        }
        catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error while updating category',
                'message' => $e->getMessage(),
            ], 500);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error updating category',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);
            }
        catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error while deleting category',
                'message' => $e->getMessage(),
            ], 500);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error deleting category',
                'error' => $e->getMessage()
            ], 400);
        
        }
    }
}
