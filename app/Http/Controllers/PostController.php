<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Hiển thị form tạo bài viết
    public function create()
    {
        return view('posts.create');
    }

    // Lưu bài viết mới vào database
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // 2. Tạo bài viết mới
        Post::create($validated);

        // 3. Quay về trang chủ
        return redirect('/')->with('success', 'Bài viết đã được tạo thành công!');
    }

    // Hiển thị chi tiết bài viết
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect('/posts/' . $id)->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    // Xóa bài viết
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/')->with('success', 'Bài viết đã được xóa thành công!');
    }
}