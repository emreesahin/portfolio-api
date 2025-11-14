<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index() {
        try {
            $messages = Message::orderBy('created_at', 'desc')->get();

            return response()->json([
                'message' => 'Messages retrieved successfully',
                'data' => $messages,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $message = Message::find($id);

            if (!$message) {
                return response()->json(['message' => 'Message not found'], 404);
            }

            return response()->json([
                'message' => 'Message retrieved successfully',
                'data' => $message,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'message' => 'required|string',
            ]);

            $msg = Message::create($validated);

            return response()->json([
                'message' => 'Message sent successfully',
                'data' => $msg,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sending the message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $message = Message::find($id);

            if (!$message) {
                return response()->json(['message' => 'Message not found'], 404);
            }

            $message->delete();

            return response()->json([
                'message' => 'Message deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the message',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
