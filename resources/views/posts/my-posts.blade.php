@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Bài viết của tôi</h1>
            <p class="text-gray-500">Quản lý tất cả những chia sẻ của bạn tại đây.</p>
        </div>
        <a href="/posts/create"
            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Viết bài mới
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 text-green-700 p-4 mb-6 rounded-xl border border-green-200 flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Thông tin bài
                            viết</th>
                        <th
                            class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">
                            Ngày đăng</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Tương
                            tác</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Hành
                            động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($posts as $post)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div
                                    class="w-16 h-12 rounded-lg bg-gray-100 mr-4 overflow-hidden flex-shrink-0 border border-gray-200">
                                    @if($post->thumbnail)
                                    <img src="{{ asset($post->thumbnail) }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="max-w-xs md:max-w-md">
                                    <a href="/posts/{{ $post->id }}"
                                        class="text-sm font-bold text-gray-800 hover:text-blue-600 block line-clamp-1 mb-1">{{
                                        $post->title }}</a>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($post->tags as $tag)
                                        <span
                                            class="text-[9px] px-1.5 py-0.5 rounded-md bg-{{ $tag->color }}-50 text-{{ $tag->color }}-600 font-bold uppercase">{{
                                            $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 hidden md:table-cell">
                            <span class="text-xs text-gray-500">{{ $post->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-[11px] font-bold text-gray-600">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                {{ $post->comments->count() }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right space-x-2 whitespace-nowrap">
                            <a href="/posts/{{ $post->id }}/edit"
                                class="inline-flex items-center p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-lg transition-all duration-200 shadow-sm"
                                title="Chỉnh sửa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>
                            <form action="/posts/{{ $post->id }}" method="POST" class="inline"
                                onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200 shadow-sm"
                                    title="Xóa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="mb-4">
                                <svg class="w-16 h-16 text-gray-200 mx-auto" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 00-2 2H6a2 2 0 00-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-4">Bạn chưa có bài viết nào.</p>
                            <a href="/posts/create" class="text-blue-600 font-bold hover:underline">Viết bài đầu tiên
                                ngay!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection