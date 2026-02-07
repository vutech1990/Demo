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
            border-bottom: 2px solid #3b82f6;
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
            background-color: #3b82f6;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .quote {
            background: #f9fafb;
            border-left: 4px solid #d1d5db;
            padding: 15px;
            margin: 15px 0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #3b82f6; margin: 0;">Phản hồi bình luận mới</h2>
        </div>

        <p>Chào <strong>{{ $parentComment->name ?? 'Bạn' }}</strong>,</p>

        <p><strong>{{ $reply->name ?? 'Ai đó' }}</strong> vừa trả lời bình luận của bạn tại bài viết:</p>
        <h3 style="color: #111;">{{ $post->title ?? 'Bài viết' }}</h3>

        <div class="quote">
            "{{ $reply->content }}"
        </div>

        <p>Bạn có thể xem chi tiết cuộc trò chuyện và phản hồi lại bằng cách nhấn vào nút bên dưới:</p>

        <div style="text-align: center;">
            <a href="{{ url('/posts/' . ($post->id ?? 0) . '#comment-' . ($reply->id ?? 0)) }}" class="button">Xem ngay
                bình luận</a>
        </div>

        <div class="footer">
            Đây là email tự động từ hệ thống Demo WSU Blog.<br>
            Vui lòng không trả lời email này. &copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>