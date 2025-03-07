<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    });

    // Blog routes
    Route::get('/blogs', [BlogController::class, 'getAllBlogs']);
    Route::get('/blogs/{id}', [BlogController::class, 'getBlogById']);
    Route::post('/blogs', [BlogController::class, 'createBlog']);
    Route::put('/blogs/{id}', [BlogController::class, 'updateBlog']);
    Route::delete('/blogs/{id}', [BlogController::class, 'deleteBlog']);
});