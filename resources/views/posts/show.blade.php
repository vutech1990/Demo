@extends('layouts.app')

@section('content')
<style>
    html {
        scroll-behavior: smooth;
    }

    @keyframes highlight {
        0% {
            background-color: #fef08a;
        }

        100% {
            background-color: white;
        }
    }

    @keyframes highlight-reply {
        0% {
            background-color: #fef08a;
        }

        100% {
            background-color: #f9fafb;
        }
    }

    .comment-block:target {
        animation: highlight 3s ease-in-out;
    }

    .reply-block:target {
        animation: highlight-reply 3s ease-in-out;
    }
</style>

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

        @auth
        <div class="flex space-x-2">
            @if(Auth::user()->email === 'vutech1990@gmail.com' || Auth::id() === $post->user_id)
            <a href="/posts/{{ $post->id }}/edit"
                class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md shadow-sm transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Sửa
            </a>
            @endif

            @if(Auth::user()->email === 'vutech1990@gmail.com')
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
            @endif
        </div>
        @endauth
    </div>

    {{-- Nội dung bài viết --}}
    <article class="bg-white p-8 rounded-xl shadow-md">
        <header class="mb-6 border-b pb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $post->title }}
            </h1>
            <div class="flex items-center text-sm text-gray-500 space-x-4 mb-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Tác giả: <span class="font-semibold ml-1">{{ $post->user ? $post->user->name : 'Vũ Tuấn' }}</span>
                </div>
                <div class="flex items-center border-l pl-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Đăng ngày {{ $post->created_at->format('d/m/Y') }}
                </div>
            </div>

            {{-- Hiển thị Tags --}}
            @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 pt-2">
                @foreach($post->tags as $tag)
                <span
                    class="inline-block px-3 py-1 rounded-full bg-{{ $tag->color }}-50 text-{{ $tag->color }}-600 text-[11px] font-bold uppercase tracking-wider border border-{{ $tag->color }}-100">
                    #{{ $tag->name }}
                </span>
                @endforeach
            </div>
            @endif
        </header>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! $post->content !!}
        </div>
    </article>

    {{-- Phần Bình luận --}}
    <div id="comment-section" class="mt-12 bg-gray-50 p-8 rounded-xl shadow-inner">
        <h3 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                </path>
            </svg>
            Bình luận ({{ $post->comments->count() }})
        </h3>

        {{-- Form Gửi Bình luận --}}
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-10">
            <h4 class="text-lg font-semibold mb-4 text-gray-700">Để lại bình luận của bạn</h4>

            @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 mb-4 rounded border border-green-200 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error_email'))
            <div class="bg-red-50 text-red-700 p-3 mb-4 rounded border border-red-200 text-sm">
                {!! session('error_email') !!} <a href="/login" class="underline font-bold">Đăng nhập ngay</a>
            </div>
            @endif

            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    @auth
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Email của bạn</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly
                            class="w-full px-3 py-2 bg-gray-100 border rounded focus:outline-none text-gray-500 cursor-not-allowed">
                    </div>
                    @else
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Tên của bạn</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Email của bạn</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    @endauth
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-600">Nội dung bình luận</label>
                    <textarea name="content" rows="4" required
                        class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Viết gì đó về bài viết này..."></textarea>
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition shadow-sm">Gửi
                    bình luận</button>
            </form>
        </div>

        {{-- Danh sách Bình luận --}}
        <div class="space-y-6">
            @forelse($post->comments->where('parent_id', null) as $comment)
            <div id="comment-{{ $comment->id }}"
                class="comment-block bg-white p-5 rounded-lg border border-gray-100 shadow-sm transition-all duration-500">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg mr-3">
                            {{ substr($comment->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-800">{{ $comment->name }}</h5>
                            <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }} (lúc {{
                                $comment->created_at->format('H:i d/m/Y') }})</p>
                        </div>
                    </div>
                    @if($comment->user_id)
                    <span
                        class="bg-blue-50 text-blue-600 text-[10px] px-2 py-0.5 rounded-full font-semibold uppercase tracking-wider">Thành
                        viên</span>
                    @endif
                </div>
                <div class="text-gray-700 leading-relaxed mb-3">
                    {{ $comment->content }}
                </div>

                <button onclick="toggleReplyForm({{ $comment->id }})"
                    class="text-blue-600 text-xs font-semibold hover:underline">Trả lời</button>

                {{-- Form Trả lời --}}
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 pl-6 border-l-2 border-blue-100">
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            @auth
                            <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="hidden">
                            @else
                            <input type="text" name="name" placeholder="Tên của bạn" required
                                class="w-full px-3 py-1.5 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <input type="email" name="email" placeholder="Email của bạn" required
                                class="w-full px-3 py-1.5 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                            @endauth
                        </div>
                        <textarea name="content" rows="2" required placeholder="Viết phản hồi..."
                            class="w-full px-3 py-1.5 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-500 mb-2"></textarea>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                class="text-gray-500 text-xs py-1 px-3">Hủy</button>
                            <button type="submit"
                                class="bg-blue-600 text-white text-xs py-1 px-3 rounded hover:bg-blue-700 transition">Gửi
                                phản hồi</button>
                        </div>
                    </form>
                </div>

                {{-- Danh sách Phản hồi --}}
                @if($comment->replies->count() > 0)
                <div class="mt-6 space-y-4 pl-6 border-l-2 border-gray-100">
                    @foreach($comment->replies as $reply)
                    <div id="comment-{{ $reply->id }}"
                        class="reply-block bg-gray-50 p-4 rounded-lg shadow-sm transition-all duration-500">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm mr-2">
                                    {{ substr($reply->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="font-bold text-sm text-gray-800">{{ $reply->name }}</h6>
                                    <p class="text-[10px] text-gray-400">{{ $reply->created_at->diffForHumans() }} (lúc
                                        {{ $reply->created_at->format('H:i d/m/Y') }})</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-700 leading-relaxed">
                            {{ $reply->content }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-10 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-400">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endsection