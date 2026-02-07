<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $myName = 'Tuan Vu';
        $posts = Post::all();

        return view('hello', [
            'name' => $myName,
            'posts' => $posts
        ]);
    }
}