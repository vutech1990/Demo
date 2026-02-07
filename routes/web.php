<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return Inertia::render('welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// Routes xác thực
Route::get('/register', [AuthController::class , 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class , 'register']);

Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login']);

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Trang chủ
Route::get('/', [HomeController::class , 'index'])->name('home');

// Routes cho Bài viết (Yêu cầu Đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class , 'create']);
    Route::post('/posts', [PostController::class , 'store']);
    Route::get('/posts/{id}/edit', [PostController::class , 'edit']);
    Route::put('/posts/{id}', [PostController::class , 'update']);
    Route::delete('/posts/{id}', [PostController::class , 'destroy']);
});

// Routes cho Bài viết (Công khai)
Route::get('/posts/{id}', [PostController::class , 'show']);
Route::get('/posts', function () {
    return redirect('/');
});

Route::get('dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';