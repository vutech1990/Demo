@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-0">
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Viết bài mới</h1>
        <p class="text-gray-500 font-medium">Chia sẻ kiến thức, kinh nghiệm và những câu chuyện tuyệt vời của bạn.</p>
    </div>

    @if ($errors->any())
    <div
        class="bg-red-50 text-red-700 p-6 mb-8 rounded-[2rem] border border-red-100 flex items-start shadow-sm animate-in fade-in slide-in-from-top-2 duration-500">
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

    <form action="/posts" method="POST" id="post-form" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div
            class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/[0.03] border border-gray-100 p-6 md:p-10 space-y-8">
            {{-- Tiêu đề --}}
            <div>
                <label for="title"
                    class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Tiêu đề bài
                    viết</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-extrabold text-gray-900 text-lg md:text-2xl placeholder-gray-300 @error('title') border-red-500 bg-red-50/30 @enderror"
                    placeholder="Nhập tiêu đề hấp dẫn và rõ ràng...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Ảnh Thumbnail --}}
                <div>
                    <label for="thumbnail"
                        class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Ảnh đại
                        diện (Thumbnail)</label>
                    <div class="relative group">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div
                            class="w-full h-40 md:h-48 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 group-hover:bg-blue-50/50 group-hover:border-blue-200 transition-all flex flex-col items-center justify-center p-6 text-center">
                            <div
                                class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-600 mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-500 group-hover:text-blue-600">Click để chọn ảnh
                                hoặc kéo thả</span>
                            <span class="text-[10px] text-gray-400 font-medium mt-1">JPG, PNG, WEBP (Tối đa 2MB)</span>
                        </div>
                    </div>
                </div>

                {{-- Nhãn dán --}}
                <div>
                    <label for="tags-input"
                        class="block mb-3 text-xs font-extrabold text-gray-400 uppercase tracking-widest pl-1">Nhãn dán
                        (Tags)</label>
                    <div class="relative mb-4">
                        <input type="text" id="tags-input" name="tags" value="{{ old('tags') }}"
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-300 font-bold text-gray-800 placeholder-gray-300"
                            placeholder="Laravel, PHP, Web Design...">
                    </div>

                    @if($tags->count() > 0)
                    <div class="p-4 bg-blue-50/30 rounded-2xl border border-blue-100/50">
                        <p class="text-[9px] text-blue-600 mb-3 uppercase font-extrabold tracking-widest">Thêm nhanh
                            nhãn dán:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <button type="button" onclick="addTag('{{ $tag->name }}')"
                                class="px-3 py-1 bg-white hover:bg-blue-600 text-gray-600 hover:text-white text-[10px] font-extrabold rounded-lg shadow-sm transition-all duration-300 border border-gray-100">
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
                <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <textarea id="editor" name="content" rows="12"
                        class="w-full px-4 py-2 focus:outline-none @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
            <a href="/"
                class="text-gray-400 hover:text-red-500 font-extrabold text-sm uppercase tracking-widest flex items-center transition group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Hủy bỏ thay đổi
            </a>
            <button type="submit"
                class="w-full md:w-auto px-12 py-5 bg-blue-600 hover:bg-black text-white font-extrabold rounded-[1.5rem] shadow-2xl shadow-blue-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center">
                <span>Đăng bài ngay</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
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