<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPasswordGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $newPassword;

    public function __construct($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    public function build()
    {
        return $this->subject('Mật khẩu mới của bạn')
            ->html("
                        <h2>Mật khẩu mới đã được tạo</h2>
                        <p>Chào bạn, yêu cầu khôi phục mật khẩu của bạn đã hoàn tất.</p>
                        <p>Mật khẩu mới của bạn là: <strong>{$this->newPassword}</strong></p>
                        <p>Vui lòng đăng nhập và đổi lại mật khẩu ngay để đảm bảo an toàn.</p>
                        <a href='" . url('/login') . "' style='background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Đăng nhập ngay</a>
                    ");
    }
}