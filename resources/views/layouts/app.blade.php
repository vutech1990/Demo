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

    <div class="container mx-auto px-4 max-w-4xl">
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

</html>