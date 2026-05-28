@extends('layouts.app')

@section('title', 'Home - Professional Blog')
@section('description', 'Welcome to Professional Blog - A modern platform for sharing your thoughts')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
  <div class="container-max text-center">
    <h1 class="text-5xl font-bold mb-4">Welcome to Professional Blog</h1>
    <p class="text-xl text-blue-100 mb-8">Discover insightful articles, stories, and ideas from our community</p>
    <a href="{{ route('blog.index') }}" class="btn-primary bg-white text-blue-600 hover:bg-blue-50">
      Start Reading
    </a>
  </div>
</section>

<!-- Featured Posts -->
<section class="py-16">
  <div class="container-max">
    <h2 class="text-4xl font-bold mb-12">Featured Articles</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @forelse($featured_posts ?? [] as $post)
        <div class="card overflow-hidden">
          @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
          @else
            <div class="w-full h-48 bg-gray-300"></div>
          @endif
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <span class="badge-primary">{{ $post->category->name ?? 'Uncategorized' }}</span>
              <span class="text-sm text-gray-500">{{ $post->published_at->diffForHumans() }}</span>
            </div>
            <h3 class="text-xl font-bold mb-2 truncate-2">
              <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600 transition">
                {{ $post->title }}
              </a>
            </h3>
            <p class="text-gray-600 truncate-3 mb-4">{{ $post->excerpt }}</p>
            <div class="flex items-center justify-between pt-4 border-t">
              <span class="text-sm text-gray-500">By {{ $post->author->name }}</span>
              <span class="text-sm text-gray-500">{{ $post->reading_time ?? '5' }} min read</span>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-3 text-center py-12">
          <p class="text-gray-500">No featured posts yet</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Latest Posts -->
<section class="py-16 bg-gray-100">
  <div class="container-max">
    <div class="flex justify-between items-center mb-12">
      <h2 class="text-4xl font-bold">Latest Posts</h2>
      <a href="{{ route('blog.index') }}" class="btn-outline">View All</a>
    </div>
    <div class="space-y-6">
      @forelse($latest_posts ?? [] as $post)
        <div class="card p-6 flex gap-6 hover:shadow-lg transition">
          @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
          @else
            <div class="w-32 h-32 bg-gray-300 rounded-lg flex-shrink-0"></div>
          @endif
          <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
              <span class="badge-primary">{{ $post->category->name ?? 'Uncategorized' }}</span>
              <time class="text-sm text-gray-500">{{ $post->published_at->format('M d, Y') }}</time>
            </div>
            <h3 class="text-2xl font-bold mb-2">
              <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600 transition">
                {{ $post->title }}
              </a>
            </h3>
            <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 150) }}</p>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-500">By {{ $post->author->name }}</span>
              <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Read More →</a>
            </div>
          </div>
        </div>
      @empty
        <div class="text-center py-12">
          <p class="text-gray-500 text-lg">No posts yet</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Newsletter Section -->
<section class="py-16">
  <div class="container-max">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-12 text-center">
      <h2 class="text-3xl font-bold mb-4">Subscribe to Our Newsletter</h2>
      <p class="text-blue-100 mb-8">Get the latest articles delivered to your inbox</p>
      <form class="flex gap-4 max-w-md mx-auto">
        <input type="email" placeholder="Your email" class="flex-1 px-4 py-2 rounded-lg text-gray-900" required>
        <button type="submit" class="btn-primary bg-white text-blue-600 hover:bg-blue-50">
          Subscribe
        </button>
      </form>
    </div>
  </div>
</section>
@endsection
