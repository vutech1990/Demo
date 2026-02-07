@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-2 md:px-0">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6 text-center md:text-left">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Bài viết của tôi</h1>
            <p class="text-gray-500 font-medium">Quản lý không gian sáng tạo và những chia sẻ của bạn.</p>
        </div>
        <a href="/posts/create"
            class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-black text-white font-extrabold rounded-2xl shadow-xl shadow-blue-200 transition transform hover:-translate-y-1 active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Viết bài mới
        </a>
    </div>

    @if(session('success'))
    <div
        class="bg-emerald-50 text-emerald-700 p-5 mb-8 rounded-2xl border border-emerald-100 flex items-center shadow-sm animate-in fade-in slide-in-from-top-2 duration-500">
        <div
            class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center mr-3 shadow-md shadow-emerald-200 flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="font-bold">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-2xl shadow-blue-900/[0.04] overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-[0.2em]">Thông
                            tin bài viết</th>
                        <th
                            class="px-8 py-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-[0.2em] hidden lg:table-cell text-center">
                            Thống kê</th>
                        <th
                            class="px-8 py-6 text-[10px] font-extrabold text-gray-400 uppercase tracking-[0.2em] text-right">
                            Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($posts as $post)
                    <tr class="group hover:bg-blue-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                {{-- Thumbnail --}}
                                <div
                                    class="w-20 h-14 md:w-24 md:h-16 rounded-2xl bg-gray-100 mr-5 overflow-hidden flex-shrink-0 border border-gray-100 shadow-sm transition group-hover:shadow-md">
                                    @if($post->thumbnail)
                                    <img src="{{ asset($post->thumbnail) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-300 italic bg-gray-50">
                                        <svg class="w-6 h-6 opacity-30" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                {{-- Title & Tags --}}
                                <div class="min-w-0 flex-grow">
                                    <a href="/posts/{{ $post->id }}"
                                        class="text-base font-extrabold text-gray-800 hover:text-blue-600 block line-clamp-1 mb-2 transition">{{
                                        $post->title }}</a>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($post->tags as $tag)
                                        <span
                                            class="text-[9px] px-2 py-0.5 rounded-lg bg-{{ $tag->color }}-50 text-{{ $tag->color }}-600 font-extrabold uppercase tracking-tighter">{{
                                            $tag->name }}</span>
                                        @endforeach
                                        <span
                                            class="lg:hidden text-[9px] px-2 py-0.5 rounded-lg bg-gray-50 text-gray-400 font-extrabold uppercase tracking-tighter">{{
                                            $post->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 hidden lg:table-cell">
                            <div class="flex flex-col items-center gap-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-extrabold"
                                        title="Lượt bình luận">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                            </path>
                                        </svg>
                                        {{ $post->comments->count() }}
                                    </div>
                                    <div class="flex items-center px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-xs font-extrabold"
                                        title="Lượt xem">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ $post->views ?? 0 }}
                                    </div>
                                </div>
                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{
                                    $post->created_at->format('d/m/Y') }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-right whitespace-nowrap">
                            <div class="flex justify-end gap-2">
                                <a href="/posts/{{ $post->id }}/edit"
                                    class="w-10 h-10 flex items-center justify-center bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition duration-300 shadow-sm"
                                    title="Chỉnh sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="/posts/{{ $post->id }}" method="POST" class="inline"
                                    onsubmit="return confirm('Bạn có thực sự muốn xóa bài viết này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition duration-300 shadow-sm"
                                        title="Xóa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <div
                                class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 00-2 2H6a2 2 0 00-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-lg font-extrabold mb-4">Danh sách bài viết đang trống.</p>
                            <a href="/posts/create"
                                class="inline-block px-8 py-3 bg-blue-600 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-100 hover:bg-black transition">Bắt
                                đầu viết bài ngay</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection