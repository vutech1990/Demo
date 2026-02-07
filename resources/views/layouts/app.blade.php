<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My First Laravel App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md mb-8 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600 hover:text-blue-800 transition">Demo WSU</a>

            <div class="flex items-center space-x-4">
                @auth
                <a href="/posts/create"
                    class="hidden md:inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition shadow-sm mr-2">
                    + Viết bài mới
                </a>

                <div class="flex items-center space-x-4 border-l pl-4 hidden sm:flex">
                    <a href="{{ route('posts.my') }}"
                        class="text-xs font-bold px-2 py-1 rounded bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition uppercase tracking-wider">
                        Bài viết của tôi
                    </a>
                    @if(Auth::user()->avatar)
                    <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Avatar"
                        class="w-8 h-8 rounded-full object-cover border border-blue-500">
                    @else
                    <div
                        class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs border border-blue-500">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    @endif
                    <a href="{{ route('profile.edit') }}"
                        class="text-gray-700 font-semibold hover:text-blue-600 transition">{{ Auth::user()->name }}</a>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline"
                    onsubmit="return confirm('Bạn có chắc chắn muốn đăng xuất không?');">
                    @csrf
                    <button type="submit"
                        class="text-red-500 hover:text-red-700 font-medium ml-2 text-sm border border-red-200 px-3 py-1 rounded hover:bg-red-50 transition">
                        Đăng xuất
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium mr-2">Đăng nhập</a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition shadow-sm">
                    Đăng ký
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Hiển thị thông báo thành công --}}
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center text-gray-500 mt-12 mb-6 text-sm">
        &copy; {{ date('Y') }} MyBlog. Built with Laravel.
    </footer>

</body>

</html>                             </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 font-bold hover:text-blue-600">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition shadow-lg shadow-gray-200">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 max-w-6xl">
        {{-- Thông báo --}}
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 mb-8 rounded-2xl flex items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-20 py-10 border-t border-gray-100 italic">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Demo WSU Blog. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

</body>
</html>