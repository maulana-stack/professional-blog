<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $featured_posts = \App\Models\Post::published()->featured()->limit(3)->get();
    $latest_posts = \App\Models\Post::published()->latest('published_at')->limit(6)->get();
    return view('home', [
        'featured_posts' => $featured_posts,
        'latest_posts' => $latest_posts,
    ]);
})->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
