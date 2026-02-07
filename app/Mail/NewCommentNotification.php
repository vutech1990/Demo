<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $post;
    public $author;

    public function __construct(Comment $comment, Post $post, User $author)
    {
        $this->comment = $comment;
        $this->post = $post;
        $this->author = $author;
    }

    public function build()
    {
        return $this->subject('Bài viết "' . $this->post->title . '" có bình luận mới')
            ->view('emails.new-comment');
    }
}