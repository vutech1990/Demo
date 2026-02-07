<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentReplied extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $parentComment;
    public $post;

    public function __construct(Comment $reply, Comment $parentComment, Post $post)
    {
        $this->reply = $reply;
        $this->parentComment = $parentComment;
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('Có phản hồi mới cho bình luận của bạn tại ' . ($this->post->title ?? 'bài viết'))
            ->view('emails.comment-replied');
    }
}