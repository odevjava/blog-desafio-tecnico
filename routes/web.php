<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/post/{post}', [PostController::class, 'show'])->name('posts.show');


Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::get('/user/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/user/{user}/posts', [UserController::class, 'posts'])->name('users.posts');

Route::post('/post/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/post/{post}/dislike', [PostController::class, 'dislike'])->name('posts.dislike');