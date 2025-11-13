<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    // 🔹 Login
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'E-posta veya şifre hatalı.',
                ], 401);
            }

            $abilities = $user->hasRole('admin') ? ['admin'] : ['*'];

            // Eski tokenları temizle
            $user->tokens()->delete();

            // Yeni token oluştur
            $token = $user->createToken('api_token', $abilities)->plainTextToken;

            return response()->json([
                'status'      => true,
                'message'     => 'Giriş başarılı.',
                'token'       => $token,
                'token_type'  => 'Bearer',
                'user'        => $user,
                'role'        => $user->roles->pluck('name')->first(),
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Doğrulama hatası.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Veritabanı hatası.',
                'error'   => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Giriş sırasında bir hata oluştu.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        try {
            if ($request->user() && $request->user()->currentAccessToken()) {
                $request->user()->currentAccessToken()->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Başarıyla çıkış yapıldı.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Çıkış sırasında hata oluştu.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
