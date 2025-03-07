<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page (Blog Index)
Route::get('/', [BlogController::class, 'index'])->name('home');

// Blog Routes
Route::resource('blogs', BlogController::class)->only(['index', 'show']);

// Auth Routes
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Register Routes
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'manageUsers'])->name('users.manage');
    Route::get('/users/{id}/edit', [UserController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.delete');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/blogs/manage', [BlogController::class, 'manageBlogs'])->name('blogs.manage');
    Route::get('/blogs/create', [BlogController::class, 'createBlog'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'storeBlog'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'editBlog'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'updateBlog'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'deleteBlog'])->name('blogs.delete');
});