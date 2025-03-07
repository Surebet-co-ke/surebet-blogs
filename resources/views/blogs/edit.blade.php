@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Edit Blog</h1>
            <form action="{{ route('blogs.update', $blog->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" value="{{ $blog->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                    <input type="text" name="author" id="author" value="{{ $blog->author }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="article" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Article</label>
                    <textarea name="article" id="article" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="5" required>{{ $blog->article }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image URL</label>
                    <input type="text" name="image" id="image" value="{{ $blog->image }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="video" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Video URL</label>
                    <input type="text" name="video" id="video" value="{{ $blog->video }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Blog</button>
            </form>
        </div>
    </div>
@endsection