@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-0">
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Chỉnh sửa bài viết</h1>
        <p class="text-gray-500 font-medium">Hoàn thiện nội dung của bạn để mang lại giá trị tốt nhất cho người đọc.</p>
    </div>

    @if ($errors->any())
    <div
        class="bg-red-50 text-red-700 p-6 mb-8 rounded-2xl border border-red-100 flex items-start shadow-sm animate-in fade-in slide-in-from-top-2 duration-500">
        <div
            class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-4 shadow-md shadow-red-200 flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                </path>
            </svg>
        </div>
        <div>
            <p class="font-extrabold mb-1 uppercase text-xs tracking-widest">Đã xảy ra lỗi:</p>
            <ul class="list-disc pl-4 text-sm font-medium">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div
            class="bg-white rounded-2xl shadow-xl shadow-amber-900/[0.03] border border-gray-100 p-6 md:p-10 space-y-8">
            {{-- Tiêu đề --}}
            <div>
                <label for="title"
                    class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Tiêu đề bài
                    viết</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition-all duration-300 font-extrabold text-gray-900 text-lg md:text-2xl placeholder-gray-300 @error('title') border-red-500 bg-red-50/30 @enderror"
                    placeholder="Cập nhật tiêu đề bài viết...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Ảnh Thumbnail --}}
                <div>
                    <label class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Ảnh
                        đại diện (Thumbnail)</label>

                    @if($post->thumbnail)
                    <div class="mb-4 relative group w-inline-block">
                        <img src="{{ asset($post->thumbnail) }}"
                            class="w-full h-32 md:h-40 object-cover rounded-xl shadow-md border border-gray-100">
                        <div
                            class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span
                                class="text-white text-xs font-bold px-3 py-1 bg-black/50 rounded-lg backdrop-blur-md">Ảnh
                                hiện tại</span>
                        </div>
                    </div>
                    @endif

                    <div class="relative group">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div
                            class="w-full h-24 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 group-hover:bg-amber-50/50 group-hover:border-amber-200 transition-all flex items-center justify-center p-4 text-center">
                            <div
                                class="w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center text-amber-600 mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <span
                                class="text-[11px] font-bold text-gray-500 group-hover:text-amber-600 uppercase tracking-widest">Thay
                                đổi ảnh mới</span>
                        </div>
                    </div>
                </div>

                {{-- Nhãn dán --}}
                <div>
                    <label for="tags-input"
                        class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Nhãn dán
                        (Tags)</label>
                    <div class="relative mb-4">
                        <input type="text" id="tags-input" name="tags"
                            value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}"
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-xl focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-800 placeholder-gray-300"
                            placeholder="Laravel, PHP, Web Design...">
                    </div>

                    @if($tags->count() > 0)
                    <div class="p-4 bg-amber-50/30 rounded-xl border border-amber-100/50">
                        <p class="text-[9px] text-amber-600 mb-3 uppercase font-extrabold tracking-widest">Gợi ý nhãn
                            dán:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <button type="button" onclick="addTag('{{ $tag->name }}')"
                                class="px-3 py-1 bg-white hover:bg-amber-600 text-gray-600 hover:text-white text-[10px] font-extrabold rounded-lg shadow-sm transition-all duration-300 border border-gray-100">
                                + {{ $tag->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Nội dung --}}
            <div>
                <label for="content"
                    class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Nội dung chi
                    tiết</label>
                <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                    <textarea id="editor" name="content" rows="12"
                        class="w-full px-4 py-2 focus:outline-none @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
            <a href="/posts/{{ $post->id }}"
                class="text-gray-400 hover:text-red-500 font-extrabold text-sm uppercase tracking-widest flex items-center transition group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Hủy bỏ thay đổi
            </a>
            <button type="submit"
                class="w-full md:w-auto px-12 py-5 bg-amber-500 hover:bg-black text-white font-extrabold rounded-xl shadow-2xl shadow-amber-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center">
                <span>Cập nhật ngay</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 19l7-7m0 0l-7-7m-7 7h18"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

{{-- Thêm CKEditor 5 --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}"
            },
            placeholder: 'Viết nội dung bài viết tại đây...',
        })
        .catch(error => {
            console.error(error);
        });

    function addTag(tagName) {
        const input = document.getElementById('tags-input');
        let currentTags = input.value.split(',').map(t => t.trim()).filter(t => t !== "");

        if (!currentTags.includes(tagName)) {
            currentTags.push(tagName);
            input.value = currentTags.join(', ');
        }
    }
</script>
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
        padding: 1.5rem !important;
    }

    .ck.ck-editor__main>.ck-editor__editable {
        border-color: transparent !important;
        background-color: #f9fafb !important;
    }

    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        background-color: white !important;
    }

    .ck.ck-toolbar {
        border-color: #f3f4f6 !important;
        background-color: white !important;
        padding: 0.5rem !important;
    }
</style>
@endsection