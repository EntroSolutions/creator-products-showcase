<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Primary Meta Tags -->
        <title>@yield('title', setting('seo_title', config('app.name', 'Laravel')))</title>
        <meta name="title" content="@yield('title', setting('seo_title', config('app.name', 'Laravel')))">
        <meta name="description" content="@yield('meta_description', setting('seo_description', 'Discover impressive digital products from talented creators.'))">
        <meta name="keywords" content="@yield('meta_keywords', setting('seo_keywords', 'digital products, creators, marketplace, indie hackers'))">
        <meta name="author" content="{{ config('app.name', 'Laravel') }}">
        <meta name="robots" content="index, follow">
        <meta name="language" content="{{ app()->getLocale() }}">
        <meta name="revisit-after" content="7 days">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', setting('seo_title', config('app.name', 'Laravel')))">
        <meta property="og:description" content="@yield('meta_description', setting('seo_description', 'Discover impressive digital products from talented creators.'))">
        <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', setting('seo_title', config('app.name', 'Laravel')))">
        <meta property="twitter:description" content="@yield('meta_description', setting('seo_description', 'Discover impressive digital products from talented creators.'))">
        <meta property="twitter:image" content="@yield('twitter_image', asset('images/twitter-image.jpg'))">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Favicon Links --}}
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#3498db">
        <meta name="msapplication-TileColor" content="#3498db">
        <meta name="theme-color" content="#3498db">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-black text-gray-800 dark:text-gray-200 min-h-screen">
        <div class="min-h-screen relative overflow-hidden">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 hero-pattern opacity-80"></div>
            <div class="absolute top-40 -left-20 w-80 h-80 bg-blue-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-60 -right-20 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute inset-0 dots-bg"></div>
            
            <div class="container max-w-7xl mx-auto px-4 py-12 relative z-10 animate-[fadeIn_0.5s_ease-in]">
                <!-- Header -->
                @include('partials.header')
                
                <!-- Main Content -->
                @yield('content')
                
                <!-- Footer -->
                @include('partials.footer')
            </div>
        </div>
        
        @stack('scripts')
    </body>
</html> 