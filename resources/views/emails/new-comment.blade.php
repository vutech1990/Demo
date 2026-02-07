<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #10b981;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .quote {
            background: #f9fafb;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 15px 0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #10b981; margin: 0;">Bình luận mới trên bài viết</h2>
        </div>

        <p>Chào <strong>{{ $author->name }}</strong>,</p>

        <p>Bài viết của bạn <strong>"{{ $post->title }}"</strong> vừa nhận được một bình luận mới từ <strong>{{
                $comment->name }}</strong>:</p>

        <div class="quote">
            "{{ $comment->content }}"
        </div>

        <p>Bạn có thể xem và phản hồi bình luận này tại đây:</p>

        <div style="text-align: center;">
            <a href="{{ url('/posts/' . $post->id . '#comment-' . $comment->id) }}" class="button">Xem bình luận</a>
        </div>

        <div class="footer">
            Đây là email tự động từ hệ thống Demo WSU Blog.<br>
            Vui lòng không trả lời email này. &copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>