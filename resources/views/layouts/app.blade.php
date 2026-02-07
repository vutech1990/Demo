<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo WSU - Blog Sáng tạo</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        ::selection {
            background: #3b82f6;
            color: white;
        }
    </style>
</head>

<body class="bg-[#fafafa] text-gray-900 overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    {{-- Top Navigation --}}
    <nav class="glass-nav sticky top-0 z-[100] transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <a href="/" class="group flex items-center space-x-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <span
                        class="text-xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">WSU
                        <span class="text-blue-600">Demo</span></span>
                </a>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                    {{-- Desktop Menu --}}
                    <div
                        class="hidden sm:flex items-center gap-3 mr-4 py-1 px-1 bg-gray-50 rounded-xl border border-gray-100">
                        <a href="{{ route('posts.my') }}"
                            class="px-4 py-2 text-xs font-extrabold text-gray-500 hover:text-blue-600 hover:bg-white rounded-xl transition duration-200 uppercase tracking-widest">
                            Bài của tôi
                        </a>
                        <a href="/posts/create"
                            class="px-4 py-2 text-xs font-extrabold text-white bg-blue-600 hover:bg-black rounded-xl transition duration-200 uppercase tracking-widest shadow-md shadow-blue-100">
                            Viết bài
                        </a>
                    </div>

                    {{-- Profile --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}"
                            class="group flex items-center gap-3 p-1.5 hover:bg-gray-50 rounded-xl transition duration-300">
                            <div
                                class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-extrabold text-sm border border-blue-50 shadow-inner group-hover:scale-110 transition-transform">
                                @if(Auth::user()->avatar)
                                <img src="{{ asset('avatars/' . Auth::user()->avatar) }}"
                                    class="w-full h-full object-cover rounded-xl">
                                @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <span class="hidden md:block text-sm font-extrabold text-gray-700">{{ Auth::user()->name
                                }}</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline"
                            onsubmit="return confirm('Bạn có muốn đăng xuất?');">
                            @csrf
                            <button type="submit"
                                class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-3 md:px-5 py-2 md:py-2.5 text-[11px] md:text-sm font-bold md:font-extrabold text-gray-500 hover:text-blue-600 transition">Đăng
                        nhập</a>
                    <a href="{{ route('register') }}"
                        class="px-4 md:px-6 py-2 md:py-3 bg-gray-900 text-white text-[11px] md:text-sm font-bold md:font-extrabold rounded-xl md:rounded-2xl hover:bg-blue-600 transition shadow-lg shadow-gray-200">Bắt
                        đầu ngay</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-6xl">
        {{-- Custom Notification --}}
        @if(session('success'))
        <div class="max-w-4xl mx-auto mb-10 animate-in fade-in slide-in-from-top-4 duration-700">
            <div
                class="bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-xl shadow-emerald-100 flex items-center justify-between">
                <div class="flex items-center gap-3 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-20 pb-20 pt-10 border-t border-gray-100">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <span class="text-sm font-extrabold text-gray-400 tracking-tighter uppercase">Demo WSU Blog
                    Framework</span>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">&copy; {{ date('Y') }} Tất cả các ý
                tưởng được bảo mật.</p>
        </div>
    </footer>

</body>

</html>