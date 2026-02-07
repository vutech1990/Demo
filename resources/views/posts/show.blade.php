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

    /* Tối ưu hiển thị ảnh trong nội dung */
    .prose img {
        border-radius: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
    }
</style>

<div class="max-w-4xl mx-auto px-4 md:px-0">
    {{-- Thanh điều hướng --}}
    <div class="mb-8 flex justify-between items-center">
        <a href="/" class="group flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition">
            <div
                class="w-8 h-8 rounded-xl bg-white shadow-sm flex items-center justify-center mr-2 group-hover:bg-blue-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            Quay lại trang chủ
        </a>

        @auth
        <div class="flex space-x-2">
            @if(Auth::user()->email === 'vutech1990@gmail.com' || Auth::id() === $post->user_id)
            <a href="/posts/{{ $post->id }}/edit"
                class="inline-flex items-center px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white text-xs font-bold rounded-lg transition shadow-sm">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Chỉnh sửa
            </a>
            @endif

            @if(Auth::user()->email === 'vutech1990@gmail.com')
            <form action="/posts/{{ $post->id }}" method="POST"
                onsubmit="return confirm('Bạn chắc chắn muốn xóa bài viết này?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs font-bold rounded-lg transition shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Xóa bài
                </button>
            </form>
            @endif
        </div>
        @endauth
    </div>

    {{-- Nội dung bài viết --}}
    <article class="bg-white rounded-2xl shadow-xl shadow-blue-900/[0.03] border border-gray-100 overflow-hidden">
        {{-- Hero Image --}}
        @if($post->thumbnail)
        <div class="w-full aspect-[21/9] overflow-hidden">
            <img src="{{ asset($post->thumbnail) }}" class="w-full h-full object-cover">
        </div>
        @endif

        <div class="p-6 md:p-12">
            <header class="mb-10 text-center md:text-left">
                {{-- Tags --}}
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-6">
                    @foreach($post->tags as $tag)
                    <span
                        class="px-4 py-1.5 rounded-lg bg-{{ $tag->color }}-50 text-{{ $tag->color }}-600 text-[10px] font-extrabold uppercase tracking-widest border border-{{ $tag->color }}-100">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>

                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight tracking-tight">
                    {{ $post->title }}
                </h1>

                <div
                    class="flex flex-col md:flex-row items-center md:justify-between gap-4 py-6 border-y border-gray-50">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-200 overflow-hidden">
                            @if($post->user && $post->user->avatar)
                            <img src="{{ asset($post->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                            {{ substr($post->user ? $post->user->name : 'U', 0, 1) }}
                            @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-extrabold text-gray-900">{{ $post->user ? $post->user->name : 'Tác
                                giả' }}</p>
                            <p class="text-xs text-gray-400 font-medium">Published on {{ $post->created_at->format('M d,
                                Y') }}</p>
                        </div>
                    </div>

                    <div class="center flex items-center space-x-4 text-gray-400">
                        <div class="flex items-center text-xs font-bold uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            {{ 1234 + $post->id }} views
                        </div>
                    </div>
                </div>
            </header>

            <div
                class="prose prose-lg max-w-none text-gray-700 leading-[1.8] font-medium prose-headings:text-gray-900 prose-headings:font-extrabold prose-a:text-blue-600 prose-strong:text-gray-900">
                {!! $post->content !!}
            </div>
        </div>
    </article>

    {{-- Phần Bình luận --}}
    <div id="comment-section"
        class="mt-12 bg-white rounded-2xl p-6 md:p-12 shadow-xl shadow-blue-900/[0.03] border border-gray-100">
        <h3 class="text-2xl font-extrabold text-gray-900 mb-10 flex items-center">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
            </div>
            Bình luận ({{ $post->comments->count() }})
        </h3>

        {{-- Form Gửi Bình luận --}}
        <div class="bg-gray-50 p-6 md:p-8 rounded-2xl mb-12 border border-blue-50/50">
            <h4 class="text-lg font-bold mb-6 text-gray-800">Chia sẻ suy nghĩ của bạn</h4>

            @if(session('success'))
            <div
                class="bg-emerald-50 text-emerald-700 p-4 mb-6 rounded-lg border border-emerald-100 text-sm font-bold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    @auth
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Đang bình
                            luận với email:</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" readonly
                            class="w-full px-5 py-3.5 bg-white border-white rounded-xl focus:outline-none text-gray-400 font-bold shadow-sm cursor-not-allowed">
                    </div>
                    @else
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Tên của
                            bạn</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="w-full px-5 py-3.5 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent transition shadow-sm font-bold placeholder-gray-300">
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Email của
                            bạn</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="w-full px-5 py-3.5 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent transition shadow-sm font-bold placeholder-gray-300">
                    </div>
                    @endauth
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest">Nội dung bình
                        luận</label>
                    <textarea name="content" rows="4" required
                        class="w-full px-5 py-4 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent transition shadow-sm font-medium placeholder-gray-300"
                        placeholder="Tham gia thảo luận..."></textarea>
                </div>

                <button type="submit"
                    class="w-full md:w-auto px-10 py-4 bg-blue-600 hover:bg-black text-white font-extrabold rounded-xl transition shadow-lg shadow-blue-100 transform active:scale-95">
                    Gửi bình luận ngay
                </button>
            </form>
        </div>

        {{-- Danh sách Bình luận --}}
        <div class="space-y-8">
            @php
            $rootComments = $post->comments->where('parent_id', null);
            @endphp
            @forelse($rootComments as $comment)
            <div id="comment-{{ $comment->id }}"
                class="comment-block group p-6 md:p-8 rounded-2xl bg-white border border-gray-100 hover:border-blue-100 transition-all duration-500">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-extrabold text-xl shadow-md">
                            {{ substr($comment->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h5 class="font-extrabold text-gray-900">{{ $comment->name }}</h5>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{
                                $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="text-gray-700 leading-relaxed font-medium mb-6 pl-2">
                    {{ $comment->content }}
                </div>

                <div class="flex items-center space-x-4">
                    <button onclick="toggleReplyForm({{ $comment->id }})"
                        class="text-[11px] font-extrabold text-blue-600 hover:text-black uppercase tracking-widest flex items-center transition group/btn">
                        <svg class="w-4 h-4 mr-1 transform group-hover/btn:-rotate-12 transition" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Phản hồi
                    </button>
                </div>

                {{-- Form Trả lời --}}
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-8 pl-6 md:pl-12 border-l-4 border-blue-50">
                    <form action="{{ route('comments.store', $post->id) }}" method="POST"
                        class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            @auth
                            <input type="email" name="email" value="{{ Auth::user()->email }}" readonly class="hidden">
                            @else
                            <input type="text" name="name" placeholder="Tên của bạn" required
                                class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-bold transition">
                            <input type="email" name="email" placeholder="Email (không hiện công khai)" required
                                class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-bold transition">
                            @endauth
                        </div>
                        <textarea name="content" rows="3" required
                            placeholder="Viết phản hồi cho {{ $comment->name }}..."
                            class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-medium mb-4 transition"></textarea>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                class="px-5 py-2.5 text-xs font-bold text-gray-400 hover:text-gray-600 transition">Hủy</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-black text-white text-xs font-extrabold rounded-lg transition shadow-md shadow-blue-50">Gửi
                                phản hồi</button>
                        </div>
                    </form>
                </div>

                {{-- Danh sách Phản hồi --}}
                @if($comment->replies->count() > 0)
                <div class="mt-10 space-y-6">
                    @foreach($comment->replies as $reply)
                    <div id="comment-{{ $reply->id }}"
                        class="reply-block group/reply bg-gray-50 p-6 rounded-2xl border border-blue-50/30 ml-4 md:ml-12 hover:bg-white hover:shadow-lg hover:shadow-blue-900/[0.02] transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-white shadow-sm rounded-lg flex items-center justify-center text-blue-600 font-extrabold text-sm border border-gray-100">
                                {{ substr($reply->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h6 class="font-extrabold text-sm text-gray-900">{{ $reply->name }}</h6>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{
                                    $reply->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-700 leading-relaxed font-medium pl-1">
                            {{ $reply->content }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-20 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-400 font-bold text-lg">Chưa có bình luận nào.</p>
                <p class="text-gray-300 text-sm mt-1">Hãy là người đầu tiên khơi dậy cuộc thảo luận!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        const allForms = document.querySelectorAll('[id^="reply-form-"]');

        allForms.forEach(f => {
            if (f.id !== `reply-form-${commentId}`) f.classList.add('hidden');
        });

        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.querySelector('textarea').focus();
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endsection