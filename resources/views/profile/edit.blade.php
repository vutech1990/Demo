@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-100">
    <div class="flex items-center space-x-4 mb-8 pb-6 border-b">
        <div class="relative">
            @if($user->avatar)
            <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar"
                class="w-16 h-16 rounded-full object-cover border-2 border-blue-500">
            @else
            <div
                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl border-2 border-blue-500">
                {{ substr($user->name, 0, 1) }}
            </div>
            @endif
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Cài đặt tài khoản</h2>
            <p class="text-gray-500 text-sm">Cập nhật thông tin cá nhân của bạn</p>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Đổi tên --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Họ và tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email (Chỉ đọc) --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Địa chỉ Email (Không thể đổi)</label>
            <input type="email" value="{{ $user->email }}" disabled
                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 text-gray-500 rounded-lg cursor-not-allowed">
            <span class="text-[10px] text-gray-400 mt-1 italic">* Liên hệ quản trị viên để thay đổi email</span>
        </div>

        {{-- Đổi Ảnh đại diện --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Ảnh đại diện mới</label>
            <input type="file" name="avatar" accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
            <p class="text-[10px] text-gray-400 mt-1">Định dạng: JPG, PNG, GIF (Tối đa 2MB)</p>
            @error('avatar')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t pt-6 mt-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Đổi mật khẩu</h3>
            <p class="text-xs text-gray-500 mb-4">(Để trống nếu bạn không muốn thay đổi mật khẩu)</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mật khẩu mới</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end space-x-3 border-t pt-6">
            <a href="/" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Hủy bỏ</a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition duration-200 shadow-lg">
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection