@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Chỉnh sửa bài viết</h1>

    @if ($errors->any())
    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded border border-red-200">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Tiêu đề bài viết</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:outline-none transition @error('title') border-red-500 @enderror">
        </div>

        <div class="mb-6">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-700">Nội dung</label>
            <textarea id="content" name="content" rows="8" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:outline-none transition @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="/posts/{{ $post->id }}" class="text-gray-500 hover:text-gray-700 font-medium">Hủy bỏ</a>
            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow transition transform hover:scale-105">
                Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection