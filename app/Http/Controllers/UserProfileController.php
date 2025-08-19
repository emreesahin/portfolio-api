<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    // Admin Info Show
    public function show()
    {
        try {
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'message' => 'Kullanıcı bilgileri başarıyla getirildi.',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bilgileri alınırken hata oluştu.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // Admin Info Update
    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'nullable|string|max:150',
                'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Profiliniz başarıyla güncellendi.',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Profil güncellenirken hata oluştu.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // Admin Info Show Public
  public function public()
{
    try {
        $user = \App\Models\User::findOrFail(1); // admin user id=1

        return response()->json([
            'status' => true,
            'message' => 'Public profil bilgileri getirildi.',
            'data' => [
                'name' => $user->name,
                'title' => $user->title,
                'bio' => $user->bio,
                'email' => $user->email, // istersen kaldırabilirsin
                'social' => [
                    'github' => $user->github_url,
                    'linkedin' => $user->linkedin_url,
                    'twitter' => $user->twitter_url,
                ]
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Public profil getirilemedi.',
            'errors' => $e->getMessage(),
        ], 500);
    }
}


}
