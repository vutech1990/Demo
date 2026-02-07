@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Đăng nhập</h2>

    @if ($errors->has('email'))
    <div class="bg-red-50 text-red-700 p-3 mb-4 rounded text-sm border border-red-200">
        {{ $errors->first('email') }}
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-bold text-gray-700">Mật khẩu</label>
            <input type="password" name="password" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
            Đăng nhập
        </button>
    </form>

    <div class="mt-6 text-center border-t pt-4">
        <p class="text-sm text-gray-600">
            Chưa có tài khoản? <a href="{{ route('register') }}"
                class="text-blue-600 hover:text-blue-800 font-semibold">Đăng ký ngay</a>
        </p>
    </div>
</div>
@endsection