<?php

namespace App\Http\Controllers;

use App\Models\{Post, Category, Comment};
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Show all blog posts.
     */
    public function index(): View
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::withCount('posts')->get();

        return view('blog.index', [
            'posts' => $posts,
            'categories' => $categories,
            'popular_tags' => [],
        ]);
    }

    /**
     * Show a single blog post.
     */
    public function show(string $slug): View
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        $related_posts = $post->getRelatedPosts(3);

        return view('blog.show', [
            'post' => $post,
            'related_posts' => $related_posts,
        ]);
    }

    /**
     * Show posts by category.
     */
    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(10);

        return view('blog.category', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
