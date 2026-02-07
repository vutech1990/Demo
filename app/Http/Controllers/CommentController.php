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
                return redirect(url()->previous() . '#comment-section')->withInput()->with('error_email', 'Email này đã được đăng ký tài khoản thành viên. Đây có phải là email của bạn không? Nếu đúng, vui lòng đăng nhập để bình luận.');
            }
        }

        $validated = $request->validate([
            'name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'content' => 'required|string',
        ]);

        $newComment = Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'name' => Auth::check() ?Auth::user()->name : $request->name,
            'email' => Auth::check() ?Auth::user()->email : $request->email,
            'content' => $request->content,
        ]);

        // TRƯỜNG HỢP 1: Đây là một phản hồi (Reply) -> Gửi mail cho người bị phản hồi
        if ($newComment->parent_id) {
            $parentComment = Comment::find($newComment->parent_id);
            // Không gửi email nếu người phản hồi chính là chủ của bình luận đó để tránh spam
            if ($parentComment && $parentComment->email !== $newComment->email) {
                try {
                    \Illuminate\Support\Facades\Mail::to($parentComment->email)
                        ->send(new \App\Mail\CommentReplied($newComment, $parentComment, $post));
                }
                catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Mail Error (Reply): ' . $e->getMessage());
                }
            }
        }
        // TRƯỜNG HỢP 2: Đây là bình luận mới (Top-level) -> Gửi mail cho tác giả bài viết
        else {
            $author = $post->user;
            // Chỉ gửi nếu bài viết có tác giả, và không phải chính tác giả tự bình luận bài của mình
            if ($author && $author->email && $author->email !== $newComment->email) {
                try {
                    \Illuminate\Support\Facades\Mail::to($author->email)
                        ->send(new \App\Mail\NewCommentNotification($newComment, $post, $author));
                }
                catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Mail Error (New Comment): ' . $e->getMessage());
                }
            }
        }

        return redirect(url()->previous() . '#comment-' . $newComment->id)->with('success', 'Bình luận của bạn đã được đăng!');
    }
}