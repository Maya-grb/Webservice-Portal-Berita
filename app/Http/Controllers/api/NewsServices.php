<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsServices extends Controller
{
    public function get()
    {
        $news = News::with('category', 'user')->latest()->get();

        if ($news->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data berita',
            'data' => $news
        ]);
    }

    public function detail($id)
    {
        $news = News::with('category', 'user')->find($id);

        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil detail berita',
            'data' => $news
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'image'       => 'nullable|string|max:255', 
            'user_id'     => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah slug sudah ada
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        
        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $news = News::create([
            'title'        => $request->title,
            'slug'         => $slug,
            'content'      => $request->content,
            'image'        => $request->image,
            'user_id'      => $request->user_id,
            'category_id'  => $request->category_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data' => $news->load('category', 'user')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'image'       => 'nullable|string|max:255',
            'user_id'     => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek slug jika title berubah
        $slug = $news->slug;
        if ($request->title !== $news->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            
            while (News::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $news->update([
            'title'        => $request->title,
            'slug'         => $slug,
            'content'      => $request->content,
            'image'        => $request->image,
            'user_id'      => $request->user_id,
            'category_id'  => $request->category_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berita berhasil diupdate',
            'data' => $news->fresh()->load('category', 'user')
        ]);
    }

    /**
     * DELETE berita
     */
    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $news->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }

    /**
     * GET berita berdasarkan kategori
     */
    public function getByCategory($categoryId)
    {
        $news = News::with('category', 'user')
                    ->where('category_id', $categoryId)
                    ->latest()
                    ->get();

        if ($news->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada berita dalam kategori ini'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil berita berdasarkan kategori',
            'data' => $news
        ]);
    }

    /**
     * GET berita berdasarkan user/penulis
     */
    public function getByUser($userId)
    {
        $news = News::with('category', 'user')
                    ->where('user_id', $userId)
                    ->latest()
                    ->get();

        if ($news->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'User ini belum memiliki berita'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil berita berdasarkan penulis',
            'data' => $news
        ]);
    }

    /**
     * GET berita terbaru dengan limit
     */
    public function getLatest($limit = 5)
    {
        $news = News::with('category', 'user')
                    ->latest()
                    ->limit($limit)
                    ->get();

        if ($news->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada berita terbaru'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil berita terbaru',
            'data' => $news
        ]);
    }

    /**
     * SEARCH berita berdasarkan title atau content
     */
    public function search(Request $request)
    {
        $keyword = $request->query('q');
        
        if (!$keyword) {
            return response()->json([
                'status' => false,
                'message' => 'Keyword pencarian diperlukan'
            ], 422);
        }

        $news = News::with('category', 'user')
                    ->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%")
                    ->latest()
                    ->get();

        if ($news->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Hasil pencarian untuk: ' . $keyword,
            'data' => $news
        ]);
    }
}