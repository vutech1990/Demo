@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-6">
    Xin chào, {{ $name }}! (Demo WSU)
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($posts as $post)
    <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2 truncate" title="{{ $post->title }}">
                <a href="/posts/{{ $post->id }}" class="hover:text-blue-600 transition">{{ $post->title }}</a>
            </h2>
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                {{ strip_tags($post->content) }}
            </p>
            <div class="flex items-center justify-between text-xs border-t pt-4">
                <div class="text-gray-400 flex items-center space-x-3">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $post->created_at->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center border-l pl-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $post->user ? $post->user->name : 'Vũ Tuấn' }}
                    </div>
                </div>
                <a href="/posts/{{ $post->id }}" class="text-blue-500 font-semibold hover:text-blue-700 transition">Đọc
                    tiếp →</a>
            </div>
        </div>
    </article>
    @endforeach
</div>

@if($posts->isEmpty())
<div class="text-center py-12 text-gray-500">
    <p class="text-lg">Chưa có bài viết nào.</p>
    <a href="/posts/create" class="text-blue-600 hover:underline mt-2 inline-block">Hãy viết bài đầu tiên!</a>
</div>
@endif
@endsection