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

// ... (code cũ đã comment)

Route::get('/', [HomeController::class , 'index']);

// Routes cho Bài viết
Route::get('/posts/create', [PostController::class , 'create']);
Route::post('/posts', [PostController::class , 'store']);
Route::get('/posts/{id}', [PostController::class , 'show']);
Route::delete('/posts/{id}', [PostController::class , 'destroy']);
Route::get('/posts/{id}/edit', [PostController::class , 'edit']);
Route::put('/posts/{id}', [PostController::class , 'update']);
Route::get('/posts', function () {
    return redirect('/');
});

Route::get('dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';