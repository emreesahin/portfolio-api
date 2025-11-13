<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    public function show()
    {
        try{
            $about = About::first();
            if (!$about) {
                return response()->json(['message' => 'About information not found'], 404);
            }
            return response()->json([
                'message' => 'About content retrieved successfully',
                'data' => $about,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving about information',
                'error' => $e->getMessage()
            ], 500
            );
        }
    }

    public function update(Request $request) {
        try{
            $about = About::firstOrCreate();

            $validated = $request-> validate([
                'name' => 'nullable|string|max:255',
                'role' => 'nullable|string|max:255',
                'avatar' => 'nullable|string|max:255',
                'bio' => 'nullable|array',
                'skills' => 'nullable|array',
            ]);

            $about->update($validated);

            return response()->json([
                'message' => 'About content updated successfully',
                'data' => $about,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating about information',
                'error' => $e->getMessage()
            ], 500
            );
        }
    }
}
