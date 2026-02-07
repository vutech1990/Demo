@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Đăng ký tài khoản</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700">Họ và tên</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700">Mật khẩu</label>
            <input type="password" name="password" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
            @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-bold text-gray-700">Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
            Đăng ký tài khoản
        </button>
    </form>

    <div class="mt-6 text-center border-t pt-4">
        <p class="text-sm text-gray-600">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Đăng
                nhập ngay</a>
        </p>
    </div>
</div>
@endsection