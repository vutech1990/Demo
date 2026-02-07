<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPasswordLink;
use App\Mail\NewPasswordGenerated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Hiển thị form nhập email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Xử lý gửi email xác nhận
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Tạo URL có chữ ký bảo mật, hết hạn trong 60 phút
        $url = URL::temporarySignedRoute(
            'password.reset.confirm',
            now()->addMinutes(60),
        ['email' => $request->email]
        );

        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return back()->with('status', 'Chúng tôi đã gửi link xác nhận khôi phục mật khẩu vào email của bạn!');
    }

    // Xử lý khi người dùng nhấn vào link trong email
    public function confirmReset(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Link xác nhận không hợp lệ hoặc đã hết hạn!');
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Tạo mật khẩu ngẫu nhiên mới
        $newPassword = Str::random(10);
        $user->password = Hash::make($newPassword);
        $user->save();

        // Gửi email mật khẩu mới
        Mail::to($user->email)->send(new NewPasswordGenerated($newPassword));

        return redirect('/login')->with('success', 'Mật khẩu mới đã được gửi vào email của bạn. Vui lòng kiểm tra hộp thư!');
    }
}