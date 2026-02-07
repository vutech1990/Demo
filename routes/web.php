<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;

// Trang chủ
Route::get('/', [HomeController::class , 'index'])->name('home');

// Routes dành cho khách (Chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class , 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class , 'register']);

    Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class , 'login']);

    // Quên mật khẩu
    Route::get('/forgot-password', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password-reset/confirm', [ForgotPasswordController::class , 'confirmReset'])->name('password.reset.confirm');
});

// Khu vực yêu cầu Đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class , 'update'])->name('profile.update');

    // Quản lý bài viết cá nhân
    Route::get('/my-posts', [PostController::class , 'myPosts'])->name('posts.my');

    // Viết & Sửa bài bài viết
    Route::get('/posts/create', [PostController::class , 'create']);
    Route::post('/posts', [PostController::class , 'store']);
    Route::get('/posts/{post}/edit', [PostController::class , 'edit']);
    Route::put('/posts/{post}', [PostController::class , 'update']);
    Route::delete('/posts/{post}', [PostController::class , 'destroy']);
    Route::post('/upload-image', [PostController::class , 'uploadImage'])->name('ckeditor.upload');
});

// Routes cho Bình luận
Route::post('/posts/{post}/comments', [CommentController::class , 'store'])->name('comments.store');



// Routes cho Bài viết (Công khai)
Route::get('/posts/{post}', [PostController::class , 'show']);
Route::get('/posts', function () {
    return redirect('/');
});