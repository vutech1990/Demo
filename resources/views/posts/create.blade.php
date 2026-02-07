@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Viết bài mới</h1>

    @if ($errors->any())
    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded border border-red-200">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/posts" method="POST" id="post-form" enctype="multipart/form-data">
        @csrf

        <div class="mb-6">
            <label for="thumbnail" class="block mb-2 text-sm font-medium text-gray-700">Ảnh đại diện bài viết
                (Thumbnail)</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('thumbnail') border-red-500 @enderror">
            <p class="text-[11px] text-gray-400 mt-1 italic">Dịnh dạng: JPG, PNG, WEBP (Tối đa 2MB)</p>
        </div>

        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Tiêu đề bài viết</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition @error('title') border-red-500 @enderror"
                placeholder="Nhập tiêu đề hấp dẫn...">
        </div>

        {{-- Phần Nhãn dán (Tags) --}}
        <div class="mb-6">
            <label for="tags-input" class="block mb-2 text-sm font-medium text-gray-700">Nhãn dán (Tags)</label>
            <div class="relative">
                <input type="text" id="tags-input" name="tags" value="{{ old('tags') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                    placeholder="Nhập tag, cách nhau bởi dấu phẩy (vd: Laravel, PHP, Web)">
            </div>

            @if($tags->count() > 0)
            <div class="mt-3">
                <p class="text-[11px] text-gray-400 mb-2 uppercase font-bold tracking-wider">Gợi ý tag có sẵn:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <button type="button" onclick="addTag('{{ $tag->name }}')"
                        class="px-3 py-1 bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-700 text-xs rounded-full transition duration-200">
                        + {{ $tag->name }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="mb-6">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-700">Nội dung</label>
            <textarea id="editor" name="content" rows="8"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition @error('content') border-red-500 @enderror"
                placeholder="Chia sẻ câu chuyện của bạn...">{{ old('content') }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="/" class="text-gray-500 hover:text-gray-700 font-medium">Hủy bỏ</a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition transform hover:scale-105">
                Đăng bài
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
            }
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
        min-height: 300px;
    }
</style>
@endsection