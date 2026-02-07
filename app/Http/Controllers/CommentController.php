<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        if (!Auth::check()) {
            $userExists = User::where('email', $request->email)->exists();
            if ($userExists) {
                return back()->withInput()->with('error_email', 'Email này đã được đăng ký tài khoản thành viên. Đây có phải là email của bạn không? Nếu đúng, vui lòng đăng nhập để bình luận.');
            }
        }

        $validated = $request->validate([
            'name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id, // Lưu ID của bình luận cha nếu có
            'name' => Auth::check() ?Auth::user()->name : $request->name,
            'email' => Auth::check() ?Auth::user()->email : $request->email,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Bình luận của bạn đã được đăng!');
    }
}