@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $blog->title }}</h1>
            <p class="mt-4 text-gray-600 dark:text-gray-400">{{ $blog->article }}</p>
            <div class="mt-6">
                <a href="{{ route('blogs.index') }}" class="text-sm text-blue-500 hover:underline">Back to Blogs</a>
            </div>
        </div>
    </div>
@endsection