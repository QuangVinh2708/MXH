<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Profile\UpdateProfileInformationForm;
// Route mặc định khi truy cập vào '/'
Route::get('/', function () {
    return redirect(route('home'));
});

// Temporary fix for unknown bug.
Route::get('/favicon.ico', function () {
    return redirect(route('home'));
});

// Routes dành cho người dùng đã đăng nhập
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Routes cho bài viết
    Route::resource('posts', PostController::class);
    Route::get('/feeds', [PostController::class, 'followers'])->name('feeds');
        // Routes cho bài viết
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::resource('posts', PostController::class)->except('show');

    // Quản lý người dùng
    Route::resource('manage/users', UserController::class)->except(['create', 'show', 'store'])->names('users');
    // Xem profile người dùng
    Route::get('/{username}', [ProfileController::class, 'show'])->name('profile');
});

// Routes chỉ dành cho Admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::post('/admin/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('admin.posts.approve');
    Route::post('/admin/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('admin.posts.reject');
});

