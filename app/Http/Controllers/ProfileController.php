<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function me(Request $request){
        try{
            // Doğru: user ataması
            $user = $request->user();

            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'message' => 'User profile fetched successfully',
                'data' => $user,
                'roles' => $user->getRoleNames()
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'message' => 'Error fetching user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
