@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-100">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Quên mật khẩu?</h2>
        <p class="text-gray-500 mt-2">Nhập email của bạn để nhận link xác nhận khôi phục mật khẩu.</p>
    </div>

    @if (session('status'))
    <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 border border-green-200 text-sm">
        {{ session('status') }}
    </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                placeholder="email@example.com">
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200 shadow-lg">
            Gửi yêu cầu xác nhận
        </button>
    </form>

    <div class="mt-8 text-center border-t pt-6">
        <p class="text-gray-600 text-sm">
            Quay lại
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Đăng nhập</a>
        </p>
    </div>
</div>
@endsection