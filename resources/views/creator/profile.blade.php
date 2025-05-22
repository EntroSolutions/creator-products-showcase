@extends('layouts.app')

@section('title', $creator->name . ' - ' . config('app.name', 'Laravel'))
@section('meta_description', $creator->bio)

@section('content')
    <div class="min-h-screen relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 hero-pattern opacity-80"></div>
        <div class="absolute top-40 -left-20 w-80 h-80 bg-blue-500/10 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-60 -right-20 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl"></div>
        <div class="absolute inset-0 dots-bg"></div>
        
        <div class="container max-w-7xl mx-auto px-4 py-12 relative z-10 animate-[fadeIn_0.5s_ease-in]">
            <!-- Header/Nav -->
            <header class="mb-16">
                <nav class="flex flex-col md:flex-row justify-between items-center py-5">
                    <div class="flex items-center mb-6 md:mb-0">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="gradient-text">Creator Showcase</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('profile.index') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">
                            Creators
                        </a>
                        <a href="{{ route('products.index') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">
                            Products
                        </a>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </nav>
            </header>
            
            <!-- Breadcrumbs -->
            <div class="mb-8">
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('home') }}" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('profile.index') }}" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Creators</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">{{ $creator->name }}</span>
                </div>
            </div>
            
            <!-- Creator Profile Hero -->
            <div class="mb-20">
                <div class="blur-card bg-white/70 dark:bg-gray-800/70 rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-8 md:p-12">
                        <div class="flex flex-col lg:flex-row gap-12 items-center lg:items-start">
                            <!-- Creator Avatar -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-md opacity-70 -z-10 scale-90"></div>
                                @if($creator->profile_picture_path)
                                    <div class="w-40 h-40 rounded-full overflow-hidden image-shimmer border-4 border-white dark:border-gray-700 shadow-xl">
                                        <img src="{{ Storage::url($creator->profile_picture_path) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover image-zoom">
                                    </div>
                                @else
                                    <div class="w-40 h-40 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-5xl font-bold border-4 border-white dark:border-gray-700 shadow-xl">
                                        {{ substr($creator->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Creator Info -->
                            <div class="flex-1 text-center lg:text-left">
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">{{ $creator->name }}</h1>
                                
                                <p class="text-lg text-blue-600 dark:text-blue-400 mb-6">{{ $creator->specialty }}</p>
                                
                                <div class="mb-8">
                                    <p class="text-gray-700 dark:text-gray-300">{{ $creator->bio }}</p>
                                </div>
                                
                                <!-- Stats -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                    <div class="stat-card p-4 rounded-xl text-center">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $products->count() }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Products</div>
                                    </div>
                                    
                                    <div class="stat-card p-4 rounded-xl text-center">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($products->sum('mrr'), 0) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Monthly Revenue</div>
                                    </div>
                                    
                                    <div class="stat-card p-4 rounded-xl text-center">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($products->sum('live_users'), 0) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Active Users</div>
                                    </div>
                                    
                                    <div class="stat-card p-4 rounded-xl text-center">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($products->sum('arr'), 0) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Annual Revenue</div>
                                    </div>
                                </div>
                                
                                <!-- Social Links -->
                                <div class="flex items-center justify-center lg:justify-start space-x-4 mb-6">
                                    @if($creator->twitter)
                                        <a href="{{ $creator->twitter }}" target="_blank" class="social-icon w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-500 hover:bg-blue-500 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                                        </a>
                                    @endif
                                    
                                    @if($creator->github)
                                        <a href="{{ $creator->github }}" target="_blank" class="social-icon w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-700 hover:text-white dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                        </a>
                                    @endif
                                    
                                    @if($creator->website)
                                        <a href="{{ $creator->website }}" target="_blank" class="social-icon w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-500 hover:bg-purple-500 hover:text-white transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    @if($creator->email)
                                        <a href="mailto:{{ $creator->email }}" class="social-icon w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-500 hover:bg-green-500 hover:text-white transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                
                                <!-- Contact Button -->
                                <a href="mailto:{{ $creator->email }}" class="btn-primary inline-block py-3 px-8 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                                    Contact {{ $creator->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Creator's Products -->
            <div class="mb-24">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                    {{ $creator->name }}'s <span class="gradient-text">Products</span>
                </h2>
                
                <div class="product-grid">
                    @foreach($products as $product)
                        <div class="feature-card bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 group">
                            <div class="relative aspect-video overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 transform scale-105 group-hover:scale-100 transition-transform duration-500"></div>
                                @if($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-200 to-purple-200 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4">
                                    <div class="bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        ${{ number_format($product->mrr, 0) }} /mo
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $product->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->tags as $tag)
                                            <span class="tag text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                    
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium text-sm">
                                        View details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- CTA Section -->
            <div class="mb-20 relative">
                <div class="blur-card bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-2xl p-10 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjxwYXRoIGQ9Ik0xNiA0YzAgMi4yIDEuOCA0IDQgNHM0LTEuOCA0LTQtMS44LTQtNC00LTQgMS44LTQgNHoiLz48cGF0aCBkPSJNNDAgMjRjMCAyLjIgMS44IDQgNCA0czQtMS44IDQtNC0xLjgtNC00LTQtNCAxLjgtNCA0eiIvPjwvZz48L2c+PC9zdmc+')] opacity-40"></div>
                    <div class="relative z-10">
                        <div class="max-w-3xl mx-auto text-center">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Work with {{ $creator->name }}?</h2>
                            <p class="text-lg text-white/80 mb-8">
                                Get in touch to discuss collaboration opportunities or learn more about their products and services.
                            </p>
                            <a href="mailto:{{ $creator->email }}" class="inline-block py-3 px-8 bg-white hover:bg-gray-100 text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 pulse-animation">
                                Contact Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="relative z-10 bg-white/70 dark:bg-gray-800/70 blur-card rounded-2xl border border-gray-200 dark:border-gray-700 py-8 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-700 dark:text-gray-300 font-semibold">{{ config('app.name', 'Creator Showcase') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">© {{ date('Y') }} All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</a>
                        <a href="{{ route('products.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Products</a>
                        <a href="{{ route('profile.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Creators</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection 