<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactContent;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{

    public function showContent()
    {
        try {
            $contact = ContactContent::first();

            if (!$contact) {
                return response()->json([
                    'message' => 'Contact content not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Contact content retrieved successfully',
                'data' => $contact,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving contact content: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while retrieving contact content',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeContent(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string',
                'socials' => 'nullable|array',
                'form' => 'nullable|array',
            ]);

            $contact = ContactContent::firstOrCreate([]);
            $contact->update($validated);

            return response()->json([
                'message' => 'Contact content stored successfully',
                'data' => $contact,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing contact content: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while storing contact content',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyContent()
    {
        try {
            $contact = ContactContent::first();

            if (!$contact) {
                return response()->json([
                    'message' => 'Contact content not found',
                ], 404);
            }

            $contact->delete();

            return response()->json([
                'message' => 'Contact content deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting contact content: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while deleting contact content',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
