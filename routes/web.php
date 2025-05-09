<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\Post;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Routes
    Route::get('/posts/create', function () {
        return Inertia::render('Posts/Create');
    })->name('posts.create');

    Route::get('/posts', function () {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user:id,name')
                            ->latest()
                            ->paginate(10)
        ]);
    })->name('posts.index');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::get('/posts/{post:slug}', function (Post $post) {
        $post->load('user:id,name');

        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    })->name('posts.show');

    Route::get('/posts/{post}/edit', function (Post $post) {
        Gate::authorize('update', $post);

        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    })->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

require __DIR__.'/auth.php';
