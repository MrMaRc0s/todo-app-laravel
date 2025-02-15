<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Post;

Route::get('/', function () {
    $posts = [];
    if (auth()->check()) {
        $posts = auth()->user()->posts()->latest()->get();
        //$posts = Post::where('user_id', auth()->id())->get();
    }
    return view('home', ['posts' => $posts]);
});

Route::get('/register-page', function () {
    return view('register-page');
});

Route::get('/login-page', function () {
    return view('login-page');
});

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout']);

Route::get('/edit-post/{post}', [PostController::class, 'editPost']);

Route::put('/edit-post/{post}', [PostController::class, 'updatePost']);

Route::post('/create-post', [PostController::class, 'createPost']);

Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);


