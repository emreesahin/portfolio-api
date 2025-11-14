<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
    public function index()
    {
        try{
            $projects = Project::with('category')->get();
            return response()->json([
                'message' => 'Projects fetched successfully',
                'data' => $projects
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error fetching projects',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show(string $id){
        try{
            $project = Project::with('category')->findOrFail($id);
            return response()->json([
                'message' => 'Project fetched successfully',
                'data' => $project
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error fetching project',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store (Request $request) {
        try{
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'nullable|string',
                'url_github' => 'nullable|url',
                'url_live' => 'nullable|url',
                'gallery' => 'nullable|array',
                'gallery.*' => 'string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $project = Project::create($validated);
            return response()->json([
                'message' => 'Project created successfully',
                'data' =>$project], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error creating project',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id){
        try{
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'nullable|string',
                'url_github' => 'nullable|url',
                'url_live' => 'nullable|url',
                'gallery' => 'nullable|array',
                'gallery.*' => 'string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $project = Project::findOrFail($id);
            $project->update($validated);

            return response()->json([
                'message' => 'Project updated successfully',
                'data' => $project
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error updating project',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id){
        try{
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json([
                'message' => 'Project deleted successfully'
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error deleting project',
                'error' => $e->getMessage()
            ]);
        }
    }
}
