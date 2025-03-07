<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Get all blogs
    public function getAllBlogs()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    // Get a single blog by ID
    public function getBlogById($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    // Create a new blog
    public function createBlog(Request $request)
    {
        $request->validate([
            'author' => 'nullable|string',
            'title' => 'required|string',
            'article' => 'required|string',
            'image' => 'nullable|string',
            'video' => 'nullable|string',
        ]);

        $blog = Blog::create($request->all());
        return response()->json($blog, 201);
    }

    // Update a blog
    public function updateBlog(Request $request, $id)
    {
        $request->validate([
            'author' => 'nullable|string',
            'title' => 'sometimes|string',
            'article' => 'sometimes|string',
            'image' => 'nullable|string',
            'video' => 'nullable|string',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        return response()->json($blog);
    }

    // Delete a blog
    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(null, 204);
    }
}