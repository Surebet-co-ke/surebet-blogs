@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">All Blogs</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($blogs as $blog)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $blog->title }}</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ Str::limit($blog->article, 100) }}</p>
                    <a href="{{ route('blogs.show', $blog->id) }}" class="mt-4 inline-block text-sm text-blue-500 hover:underline">Read More</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection