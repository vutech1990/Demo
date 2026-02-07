<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags'])->latest();

        // Tìm kiếm theo tiêu đề hoặc nội dung
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%");
            });
        }

        // Lọc theo Tag
        if ($request->has('tag')) {
            $tagName = $request->get('tag');
            $query->whereHas('tags', function ($q) use ($tagName) {
                $q->where('name', $tagName);
            });
        }

        $posts = $query->paginate(6)->withQueryString();
        $name = auth()->check() ? auth()->user()->name : 'Tuan Vu';

        if ($request->ajax()) {
            return view('hello', [
                'name' => $name,
                'posts' => $posts
            ]);
        }

        return view('hello', [
            'name' => $name,
            'posts' => $posts
        ]);
    }
}