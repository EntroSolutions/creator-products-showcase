@extends('layouts.app')

@section('title', 'Creators - ' . config('app.name', 'Laravel'))
@section('meta_description', 'Discover talented creators and their amazing products.')

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
            
            <!-- Hero Section -->
            <div class="mb-20 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    Meet Our <span class="gradient-text">Extraordinary</span> Creators
                </h1>
                <p class="max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300">
                    Discover the talented individuals behind our most successful digital products. Browse through their profiles and explore their impressive portfolios.
                </p>
            </div>
            
            <!-- Creators Grid -->
            <div class="profile-grid mb-16">
                @foreach($creators as $creator)
                    <div class="feature-card bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 group">
                        <div class="p-8 flex flex-col items-center text-center">
                            <!-- Creator Avatar -->
                            <div class="mb-6 relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-md opacity-70 -z-10 scale-90"></div>
                                @if($creator->profile_picture_path)
                                    <div class="w-24 h-24 rounded-full overflow-hidden image-shimmer border-4 border-white dark:border-gray-700 shadow-xl">
                                        <img src="{{ Storage::url($creator->profile_picture_path) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover image-zoom">
                                    </div>
                                @else
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-white dark:border-gray-700 shadow-xl">
                                        {{ substr($creator->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $creator->name }}</h3>
                            
                            @if($creator->specialty)
                                <p class="text-blue-600 dark:text-blue-400 mb-4">{{ $creator->specialty }}</p>
                            @endif
                            
                            <div class="flex justify-center space-x-3 mb-4">
                                <div class="text-center">
                                    <span class="block text-xl font-bold text-gray-800 dark:text-white">{{ $creator->products_count }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Products</span>
                                </div>
                                
                                @if($creator->total_mrr)
                                    <div class="text-center">
                                        <span class="block text-xl font-bold text-gray-800 dark:text-white">${{ number_format($creator->total_mrr, 0) }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Monthly</span>
                                    </div>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-3">
                                {{ $creator->bio ?? 'A passionate creator dedicated to building innovative digital products.' }}
                            </p>
                            
                            <div class="flex mb-4 space-x-2">
                                @if($creator->twitter)
                                    <a href="{{ $creator->twitter }}" target="_blank" class="social-icon w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                                    </a>
                                @endif
                                
                                @if($creator->github)
                                    <a href="{{ $creator->github }}" target="_blank" class="social-icon w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                @endif
                                
                                @if($creator->website)
                                    <a href="{{ $creator->website }}" target="_blank" class="social-icon w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            
                            <a href="{{ route('creator.profile', $creator) }}" class="btn-primary inline-block py-2 px-4 text-white text-sm font-medium rounded-lg shadow hover:shadow-lg transition-all transform hover:-translate-y-1">
                                View Profile
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $creators->links() }}
            </div>
            
            <!-- CTA Section -->
            <div class="mt-24 mb-16 relative">
                <div class="blur-card bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-2xl p-10 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjxwYXRoIGQ9Ik0xNiA0YzAgMi4yIDEuOCA0IDQgNHM0LTEuOCA0LTQtMS44LTQtNC00LTQgMS44LTQgNHoiLz48cGF0aCBkPSJNNDAgMjRjMCAyLjIgMS44IDQgNCA0czQtMS44IDQtNC0xLjgtNC00LTQtNCAxLjgtNCA0eiIvPjwvZz48L2c+PC9zdmc+')] opacity-40"></div>
                    <div class="relative z-10">
                        <div class="max-w-3xl mx-auto text-center">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Join Our Creator Community?</h2>
                            <p class="text-lg text-white/80 mb-8">
                                Showcase your digital products to a growing audience and connect with like-minded creators.
                            </p>
                            <a href="{{ route('register') }}" class="inline-block py-3 px-8 bg-white hover:bg-gray-100 text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 pulse-animation">
                                Register Now
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