@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Thanh điều hướng nhỏ --}}
    <div class="mb-6 flex justify-between items-center">
        <a href="/" class="text-blue-600 hover:text-blue-800 flex items-center transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Quay lại trang chủ
        </a>

        <div class="flex space-x-2">
            {{-- Nút Chỉnh sửa --}}
            <a href="/posts/{{ $post->id }}/edit"
                class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow-sm transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Sửa
            </a>

            {{-- Nút Xóa --}}
            <form action="/posts/{{ $post->id }}" method="POST"
                onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md shadow-sm transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Xóa
                </button>
            </form>
        </div>
    </div>

    {{-- Nội dung bài viết --}}
    <article class="bg-white p-8 rounded-xl shadow-md">
        <header class="mb-6 border-b pb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $post->title }}
            </h1>
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Đăng ngày {{ $post->created_at->format('d/m/Y') }} lúc {{ $post->created_at->format('H:i') }}
            </div>
        </header>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $post->content }}
        </div>
    </article>
</div>
@endsection