@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[70vh] px-4 py-10">
    <div class="max-w-md w-full animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Gia nhập cộng đồng</h1>
            <p class="text-gray-500 font-medium">Bắt đầu hành trình chia sẻ kiến thức của bạn ngay hôm nay.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-2xl shadow-blue-900/[0.04] border border-gray-100">
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block mb-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Họ
                        và tên của bạn</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300 @error('name') border-red-500 bg-red-50/30 @enderror"
                        placeholder="Nguyễn Văn A">
                    @error('name')
                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        class="block mb-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Địa
                        chỉ Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300 @error('email') border-red-500 bg-red-50/30 @enderror"
                        placeholder="example@gmail.com">
                    @error('email')
                    <p class="text-red-500 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block mb-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Mật
                            khẩu</label>
                        <input type="password" name="password" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300 @error('password') border-red-500 bg-red-50/30 @enderror"
                            placeholder="••••••••">
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Xác
                            nhận</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300"
                            placeholder="••••••••">
                    </div>
                </div>

                @error('password')
                <p class="text-red-500 text-[10px] font-bold mt-0 ml-1 uppercase tracking-wider">{{ $message }}</p>
                @enderror

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-5 bg-blue-600 hover:bg-black text-white font-extrabold rounded-2xl transition-all shadow-xl shadow-blue-100 transform active:scale-95 flex items-center justify-center">
                        <span>Tạo tài khoản ngay</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </button>
                    <p class="text-[10px] text-gray-400 text-center mt-4 font-medium italic">Bằng cách đăng ký, bạn đồng
                        ý với các điều khoản của chúng tôi.</p>
                </div>
            </form>

            <div class="mt-10 text-center border-t border-gray-50 pt-8">
                <p class="text-sm text-gray-500 font-medium">
                    Đã là thành viên? <a href="{{ route('login') }}"
                        class="text-blue-600 hover:text-black font-extrabold ml-1 transition">Đăng nhập ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection