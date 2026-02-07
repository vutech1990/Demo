<?php

// Routes cho Bài viết (Công khai)
Route::get('/posts/{id}', [PostController::class , 'show']);
Route::get('/posts', function () {
    return redirect('/');
}); App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;

// Routes xác thực
Route::get('/register', [AuthController::class , 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class , 'register']);

Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login']);

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Quên mật khẩu
Route::get('/forgot-password', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
Route::get('/password-reset/confirm', [ForgotPasswordController::class , 'confirmReset'])->name('password.reset.confirm');

// Trang chủ
Route::get('/', [HomeController::class , 'index'])->name('home');

// Hồ sơ cá nhân (Yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class , 'update'])->name('profile.update');
});

// Routes cho Bình luận
Route::post('/posts/{id}/comments', [CommentController::class , 'store'])->name('comments.store');

// Routes cho Bài viết (Yêu cầu Đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class , 'create']);
    Route::post('/posts', [PostController::class , 'store']);
    Route::get('/posts/{id}/edit', [PostController::class , 'edit']);
    Route::put('/posts/{id}', [PostController::class , 'update']);
    Route::delete('/posts/{id}', [PostController::class , 'destroy']);
    Route::post('/upload-image', [PostController::class , 'uploadImage'])->name('ckeditor.upload');
});

// Routes cho Bài viết (Công khai)
Route::get('/posts/{id}', [PostController::class , 'show']);
Route::get('/posts', function () {
    return redirect('/');
});