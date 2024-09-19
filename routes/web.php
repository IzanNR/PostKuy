<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// routes/web.php

// Route default
Route::get('/', function () {
    return redirect('/home'); // Mengarahkan ke halaman /home
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

// Users Routes
Route::get('users/{username}', [UserController::class, 'show'])->name('users.show'); // Ganti route untuk username

// Posts Routes
Route::resource('posts', PostController::class);

// Comments Routes
Route::resource('comments', CommentController::class);

// Votes Routes
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/vote', [VoteController::class, 'store']);
    // Other routes that require authentication
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    // Other routes that require authentication
});

// Define the home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
