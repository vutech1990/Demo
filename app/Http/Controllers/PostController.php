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
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(), // Lưu ID người đăng
        ]);

        return redirect('/')->with('success', 'Bài viết đã được đăng thành công!');
    }

    public function show($id)
    {
        $post = Post::with(['comments.replies', 'user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Kiểm tra quyền: Là Admin HOẶC là chủ bài viết
        if (auth()->user()->email !== 'vutech1990@gmail.com' && auth()->id() !== $post->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Kiểm tra quyền: Là Admin HOẶC là chủ bài viết
        if (auth()->user()->email !== 'vutech1990@gmail.com' && auth()->id() !== $post->user_id) {
            abort(403, 'Bạn không có quyền cập nhật bài viết này!');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($request->all());

        return redirect("/posts/$id")->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // CHỈ Admin mới có quyền xóa bài viết
        if (auth()->user()->email !== 'vutech1990@gmail.com') {
            abort(403, 'Chỉ Admin mới có quyền xóa bài viết này!');
        }

        $post->delete();

        return redirect('/')->with('success', 'Bài viết đã được xóa thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Di chuyển file vào thư mục public/media
            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}