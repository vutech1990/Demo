<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Xác nhận khôi phục mật khẩu')
            ->html("
                        <h2>Yêu cầu khôi phục mật khẩu</h2>
                        <p>Chào bạn, chúng tôi nhận được yêu cầu khôi phục mật khẩu của bạn.</p>
                        <p>Vui lòng nhấn vào đường dẫn dưới đây để xác nhận. Sau khi nhấn, hệ thống sẽ tạo mật khẩu mới và gửi lại cho bạn qua email này.</p>
                        <a href='{$this->url}' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Xác nhận khôi phục</a>
                        <p>Nếu bạn không yêu cầu, vui lòng bỏ qua email này.</p>
                    ");
    }
}