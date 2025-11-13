<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Exception;

class ContentController extends Controller
{
    // 🔹 Tek içerik (anasayfa)
    public function index()
    {
        $content = Content::first();
        if (!$content) {
            // hiç kayıt yoksa oluştur
            $content = Content::create([]);
        }
        return response()->json($content, 200);
    }

    // 🔹 Güncelle
    public function update(Request $request)
    {
        try {
            $content = Content::firstOrFail();
            $content->update($request->only([
                'home_title',
                'home_subtitle',
                'projects_title',
                'projects_empty',
                'contact_title',
                'contact_text',
                'contact_button'
            ]));

            return response()->json([
                'message' => 'Content updated successfully',
                'data' => $content
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
