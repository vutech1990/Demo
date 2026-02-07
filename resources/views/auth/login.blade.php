@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[60vh] px-4">
    <div class="max-w-md w-full animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Mừng bạn quay lại</h1>
            <p class="text-gray-500 font-medium">Đăng nhập để tiếp tục khám phá và chia sẻ.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white p-10 md:p-12 rounded-xl shadow-2xl shadow-blue-900/[0.04] border border-gray-100">
            @if ($errors->has('email'))
            <div
                class="bg-red-50 text-red-700 p-4 mb-8 rounded-lg text-xs font-bold border border-red-100 flex items-center animate-shake">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                {{ $errors->first('email') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label
                        class="block mb-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Email
                        của bạn</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-lg focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300"
                        placeholder="example@gmail.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest pl-1">Mật
                            khẩu</label>
                        <a href="{{ route('password.request') }}"
                            class="text-[10px] font-extrabold text-blue-600 hover:text-black uppercase tracking-widest transition">Quên?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-lg focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-900 placeholder-gray-300"
                        placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-5 bg-blue-600 hover:bg-black text-white font-extrabold rounded-lg transition-all shadow-xl shadow-blue-100 transform active:scale-95 flex items-center justify-center">
                        <span>Vào thế giới Demo WSU</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-10 text-center border-t border-gray-50 pt-8">
                <p class="text-sm text-gray-500 font-medium">
                    Chưa gia nhập cộng đồng? <a href="{{ route('register') }}"
                        class="text-blue-600 hover:text-black font-extrabold ml-1 transition">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }
</style>
@endsection