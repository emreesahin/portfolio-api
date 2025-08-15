<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'      => false,
                'message' => 'E-posta veya şifre hatalı.',
            ], 401);
        }


        $abilities = $user->hasRole('admin') ? ['admin'] : ['*'];
        $token = $user->createToken('api_token', $abilities)->plainTextToken;

        return response()->json([
            'status'    => true,
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'      => true,
            'message' => 'Başarıyla çıkış yapıldı.',
        ]);
    }

}
