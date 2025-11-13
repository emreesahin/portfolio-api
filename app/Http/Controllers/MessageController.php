<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){
        try{
            $messages = Contact::orderBy('created_at', 'desc')->get();

            return response()->json([
                'message' => 'Messages retrieved successfully',
                'data' => $messages,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving messages',
                'error' => $e->getMessage()
            ], 500
            );
        }
    }

    public function show($id){
        try{
            $message = Contact::find($id);
            if (!$message) {
                return response()->json(['message' => 'Message not found'], 404);
            }
            return response()->json([
                'message' => 'Message retrieved successfully',
                'data' => $message,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the message',
                'error' => $e->getMessage()
            ], 500
            );
        }
    }

    public function destroy($id){
        try{
            $message = Contact::find($id);
            if (!$message) {
                return response()->json(['message' => 'Message not found'], 404);
            }
            $message->delete();
            return response()->json([
                'message' => 'Message deleted successfully',
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the message',
                'error' => $e->getMessage()
            ], 500
            );
        }
    }
}
