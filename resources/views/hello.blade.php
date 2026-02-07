@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="text-center md:text-left">
        <h1
            class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-blue-700 to-indigo-600 bg-clip-text text-transparent mb-3 leading-tight">
            @if(request('tag'))
            Chủ đề: {{ request('tag') }}
            @elseif(request('search'))
            Kết quả tìm kiếm: "{{ request('search') }}"
            @else
            Khám phá bài viết mới
            @endif
        </h1>
        <p class="text-gray-500 text-sm md:text-lg max-w-2xl px-4 md:px-0 font-medium">
            @if(auth()->check())
            Chào mừng <strong>{{ $name }}</strong> quay trở lại. Hãy cùng theo dõi những chia sẻ mới nhất.
            @else
            Nơi chia sẻ kiến thức và khơi nguồn cảm hứng sáng tạo.
            @endif
        </p>
    </div>

    {{-- Ô tìm kiếm LIVE SEARCH --}}
    <div class="w-full md:w-80 px-4 md:px-0">
        <div class="relative group">
            <input type="text" name="search" id="live-search" value="{{ request('search') }}"
                placeholder="Tìm bài viết..." autocomplete="off"
                class="w-full pl-10 pr-10 py-3.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition shadow-sm group-hover:shadow-md">

            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg id="search-icon" class="w-5 h-5 transition-colors group-hover:text-blue-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <svg id="loading-spinner" class="w-5 h-5 animate-spin hidden text-blue-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center">
                @if(request('search') || request('tag'))
                <a href="/"
                    class="text-[10px] font-bold bg-red-50 text-red-500 px-2 py-1 rounded-md hover:bg-red-500 hover:text-white transition">Xóa
                    lọc</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="posts-container">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($posts as $post)
        <article
            class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full ring-1 ring-black/[0.02]">
            {{-- Phần ảnh Thumbnail --}}
            <a href="/posts/{{ $post->id }}"
                class="aspect-[16/9] w-full overflow-hidden relative bg-gray-100 block group/thumb">
                @if($post->thumbnail)
                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                @else
                <div
                    class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gradient-to-br from-gray-50 to-gray-100 italic transition-colors group-hover/thumb:bg-blue-50">
                    <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-xs font-medium">No cover image</span>
                </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span
                        class="px-2.5 py-1 bg-black/50 backdrop-blur-md text-white text-[10px] font-bold rounded-lg shadow-sm uppercase tracking-wider">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
            </a>

            <div class="p-6 md:p-8 flex-grow flex flex-col">
                <div class="flex flex-wrap gap-2 mb-4">
                    @forelse($post->tags as $tag)
                    <a href="/?tag={{ urlencode($tag->name) }}"
                        class="px-4 py-1.5 rounded-lg bg-{{ $tag->color }}-50 text-{{ $tag->color }}-600 text-[10px] font-extrabold uppercase tracking-widest border border-{{ $tag->color }}-100 hover:bg-{{ $tag->color }}-600 hover:text-white transition-all duration-300">
                        {{ $tag->name }}
                    </a>
                    @empty
                    <span
                        class="inline-block px-3 py-1 rounded-lg bg-gray-50 text-gray-400 text-[10px] font-extrabold uppercase tracking-widest">General</span>
                    @endforelse
                </div>

                <h2
                    class="text-xl md:text-2xl font-extrabold text-gray-900 mb-3 leading-snug group-hover:text-blue-600 transition-colors">
                    <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                </h2>

                <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3 font-medium">
                    {{ Str::limit(strip_tags($post->content), 120) }}
                </p>

                <div class="pt-5 border-t border-gray-50 flex items-center justify-between">
                    <div class="flex items-center group/author">
                        <div
                            class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold text-xs ring-4 ring-white shadow-sm overflow-hidden transition-transform group-hover/author:rotate-6">
                            @if($post->user && $post->user->avatar)
                            <img src="{{ asset($post->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                            {{ substr($post->user ? $post->user->name : 'U', 0, 1) }}
                            @endif
                        </div>
                        <div class="ml-2.5">
                            <p class="text-[11px] font-extrabold text-gray-900 truncate max-w-[100px]"
                                title="{{ $post->user ? $post->user->name : 'User' }}">
                                {{ $post->user ? $post->user->name : 'User' }}
                            </p>
                        </div>
                    </div>

                    <a href="/posts/{{ $post->id }}"
                        class="flex items-center text-blue-600 font-extrabold text-xs hover:text-black transition py-1 uppercase tracking-widest">
                        Đọc tiếp
                        <svg class="w-3.5 h-3.5 ml-1.5 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <div class="mt-12" id="pagination-links">
        {{ $posts->links() }}
    </div>

    @if($posts->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-dashed border-gray-200 px-6">
        <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <p class="text-gray-500 text-lg font-extrabold">Không tìm thấy bài viết nào phù hợp.</p>
        <a href="/"
            class="mt-4 px-8 py-3 bg-blue-600 text-white rounded-xl font-extrabold hover:bg-black transition inline-block shadow-lg shadow-blue-100">Quay
            lại tất cả bài viết</a>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('live-search');
        const container = document.getElementById('posts-container');
        const searchIcon = document.getElementById('search-icon');
        const loadingSpinner = document.getElementById('loading-spinner');
        let searchTimeout;

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchIcon.classList.add('hidden');
            loadingSpinner.classList.remove('hidden');

            searchTimeout = setTimeout(() => {
                const query = searchInput.value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.delete('page');

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('posts-container');
                        if (newContent) {
                            container.innerHTML = newContent.innerHTML;
                        }
                        window.history.pushState({}, '', url);
                        searchIcon.classList.remove('hidden');
                        loadingSpinner.classList.add('hidden');
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        searchIcon.classList.remove('hidden');
                        loadingSpinner.classList.add('hidden');
                    });
            }, 400);
        });
    });
</script>
@endsection