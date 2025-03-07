<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Home Page: List all blogs
    public function index()
    {
        $blogs = Blog::all(); // Fetch all blogs from the database
        return view('blogs.index', compact('blogs')); // Pass blogs to the view
    }

    // Show a single blog
    public function show($id)
    {
        $blog = Blog::findOrFail($id); // Fetch the blog by ID
        return view('blogs.show', compact('blog')); // Pass the blog to the view
    }

    // Manage Blogs (Admin Only)
    public function manageBlogs()
    {
        $blogs = Blog::all(); // Fetch all blogs
        return view('blogs.manage', compact('blogs')); // Pass blogs to the view
    }
    // Show the create blog form (admin only)
    public function createBlog()
    {
        return view('blogs.create');
    }

    // Store a new blog (admin only)
    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'article' => 'required|string',
            'image' => 'nullable|string',
            'video' => 'nullable|string',
        ]);

        // Create the blog
        Blog::create($request->all());

        return redirect()->route('blogs.manage')->with('success', 'Blog created successfully!');
    }

    // Update a blog (admin only)
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

        return redirect()->route('blogs.manage')->with('success', 'Blog updated successfully!');
    }

    // Delete a blog (admin only)
    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id); // Fetch the blog by ID
        $blog->delete();
        return redirect()->route('blogs.manage')->with('success', 'Blog deleted successfully!');
    }

    // API Methods

    // Get all blogs (API)
    public function getAllBlogs()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    // Get a single blog by ID (API)
    public function getBlogById($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    // Create a new blog (API)
    public function createBlogApi(Request $request)
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

    // Update a blog (API)
    public function updateBlogApi(Request $request, $id)
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
}