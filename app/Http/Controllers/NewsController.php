<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Halaman home (daftar berita)
    public function index()
    {
        $news = News::with('category', 'user')
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(10);
        
        $categories = Category::all();
        
        return view('home', compact('news', 'categories'));
    }

    // Halaman detail berita
    public function detail($slug)
    {
        $news = News::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();
        
        // Tambah views
        $news->increment('views');
        
        // Berita terkait (kategori sama)
        $related = News::where('category_id', $news->category_id)
                       ->where('id', '!=', $news->id)
                       ->where('status', 'published')
                       ->latest('published_at')
                       ->take(5)
                       ->get();
        
        return view('detail', compact('news', 'related'));
    }

    // Halaman berdasarkan kategori
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $news = News::where('category_id', $category->id)
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(10);
        
        $categories = Category::all();
        
        return view('category', compact('category', 'news', 'categories'));
    }
}