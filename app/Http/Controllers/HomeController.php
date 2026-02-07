<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $myName = 'Tuan Vu';
        $posts = Post::with('user')->get();

        return view('hello', [
            'name' => $myName,
            'posts' => $posts
        ]);
    }
}