<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Primary SEO meta --}}
    <title>@yield('title', config('app.name', 'Professional Blog'))</title>
    <meta name="description" content="@yield('description', 'Blog profesional dengan artikel berkualitas tentang teknologi, bisnis, dan lifestyle')">
    <meta name="keywords" content="@yield('keywords', 'blog, artikel, teknologi')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="author" content="@yield('author', config('app.name'))">

    {{-- Open Graph / Twitter --}}
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', @yield('description', ''))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('og_description', @yield('description', ''))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Resource Hints --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    {{-- Preload critical assets (Vite handles hashing in production; keep as hint) --}}
    @hasSection('preload')
        @yield('preload')
    @else
        {{-- Default preloads (fallback) --}}
        <link rel="preload" href="{{ asset('build/assets/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('build/assets/app.css') }}"></noscript>
        <link rel="preload" href="{{ asset('build/assets/app.js') }}" as="script">
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Vite / Assets --}}
    @if(app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- In production we rely on built files (ensure npm run build ran) --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script defer src="{{ mix('js/app.js') }}"></script>
    @endif

    @livewireStyles

    {{-- Structured data for site (basic) --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ config('app.name') }}",
        "url": "{{ config('app.url') }}"
    }
    </script>

    {{-- Google Analytics placeholder (replace ID) --}}
    @if(config('services.google.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google.analytics_id') }}');
        </script>
    @endif

    @stack('head')
</head>
<body class="antialiased bg-white text-gray-800">
    <div id="app">
        @include('partials.navbar')

        <main class="min-h-screen">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @livewireScripts

    {{-- Defer non-critical scripts --}}
    @stack('scripts')
</body>
</html>
