<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Hiển thị form tạo bài viết
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    // Lưu bài viết mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $fileName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->move(public_path('thumbnails'), $fileName);
            $thumbnailPath = 'thumbnails/' . $fileName;
        }

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'thumbnail' => $thumbnailPath,
        ]);

        if ($request->tags) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            $availableColors = ['blue', 'indigo', 'rose', 'amber', 'emerald', 'violet', 'cyan', 'fuchsia', 'orange', 'teal'];

            foreach ($tagNames as $name) {
                if (empty($name))
                    continue;
                $tag = Tag::firstOrCreate(
                ['name' => $name],
                ['color' => $availableColors[array_rand($availableColors)]]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect('/')->with('success', 'Bài viết đã được đăng thành công!');
    }

    public function show(Post $post)
    {
        $post->load(['comments.replies', 'user', 'tags']);

        // Tăng lượt xem
        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $post->load('tags');
        $tags = Tag::all();

        if (auth()->user()->email !== 'vutech1990@gmail.com' && auth()->id() !== $post->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        return view('posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->email !== 'vutech1990@gmail.com' && auth()->id() !== $post->user_id) {
            abort(403, 'Bạn không có quyền cập nhật bài viết này!');
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // Cập nhật slug nếu tiêu đề thay đổi
        if ($post->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($post->thumbnail && File::exists(public_path($post->thumbnail))) {
                File::delete(public_path($post->thumbnail));
            }

            $fileName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->move(public_path('thumbnails'), $fileName);
            $data['thumbnail'] = 'thumbnails/' . $fileName;
        }

        $post->update($data);

        if ($request->has('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            $availableColors = ['blue', 'indigo', 'rose', 'amber', 'emerald', 'violet', 'cyan', 'fuchsia', 'orange', 'teal'];

            foreach ($tagNames as $name) {
                if (empty($name))
                    continue;
                $tag = Tag::firstOrCreate(
                ['name' => $name],
                ['color' => $availableColors[array_rand($availableColors)]]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect("/posts/{$post->slug}")->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->email !== 'vutech1990@gmail.com') {
            abort(403, 'Chỉ Admin mới có quyền xóa bài viết này!');
        }

        // Xóa ảnh đại diện khi xóa bài viết
        if ($post->thumbnail && File::exists(public_path($post->thumbnail))) {
            File::delete(public_path($post->thumbnail));
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

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    // Tính năng mới: Quản lý bài viết của tôi
    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->paginate(10);
        return view('posts.my-posts', compact('posts'));
    }
}