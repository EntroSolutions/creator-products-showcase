@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name', 'Laravel'))
@section('meta_description', $product->description)

@push('styles')
<!-- CSS moved to app.css -->
@endpush

@section('content')
    <div class="container max-w-7xl mx-auto px-4 py-12 relative z-10 animate-[fadeIn_0.5s_ease-in]">
        <!-- Breadcrumbs -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('products.index') }}" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Products</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300">{{ $product->name }}</span>
            </div>
        </div>
        
        <!-- Product Hero Section -->
        <div class="mb-20">
            <div class="blur-card bg-white/70 dark:bg-gray-800/70 rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Product Image -->
                    <div class="p-6 md:p-8 flex items-center justify-center">
                        <div class="relative w-full h-full max-h-80 rounded-xl overflow-hidden shadow-lg">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover image-zoom">
                            @else
                                <div class="w-full h-full min-h-60 bg-gradient-to-br from-blue-200 to-purple-200 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <div class="bg-blue-500 text-white text-sm font-bold px-4 py-1 rounded-full shadow-lg">
                                    ${{ number_format($product->mrr, 0) }} /mo
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6 md:p-8 flex flex-col justify-center">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center mr-4">
                                @if($product->creator->profile_picture_path)
                                    <img src="{{ Storage::url($product->creator->profile_picture_path) }}" alt="{{ $product->creator->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($product->creator->name, 0, 1) }}
                                    </div>
                                @endif
                                <a href="{{ route('creator.profile', $product->creator) }}" class="ml-3 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">
                                    {{ $product->creator->name }}
                                </a>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($product->tags as $tag)
                                <a href="{{ route('products.index', ['tag' => $tag->slug]) }}" class="tag px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-8">{{ $product->description }}</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                            <div class="stats-item blur-card bg-white/40 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700 text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($product->live_users, 0) }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Active Users</div>
                            </div>
                            
                            <div class="stats-item blur-card bg-white/40 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700 text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($product->arr, 0) }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Annual Revenue</div>
                            </div>
                            
                            <div class="stats-item blur-card bg-white/40 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700 text-center col-span-2 sm:col-span-1">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $product->created_at->diffForHumans(null, true) }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Time on Market</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ $product->website_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary text-white text-center px-8 py-3 rounded-xl font-semibold transition-all">
                                Visit Website
                            </a>
                            
                            <a href="{{ route('creator.profile', $product->creator) }}" class="bg-white dark:bg-gray-800 text-center text-gray-800 dark:text-gray-200 px-8 py-3 rounded-xl font-semibold border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all hover:shadow-lg">
                                View Creator
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Long Description Section -->
        @if($product->long_description)
        <div class="mb-20">
            <div class="blur-card bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 md:p-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
                    Detailed <span class="gradient-text">Description</span>
                </h2>
                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! $product->long_description !!}
                </div>
            </div>
        </div>
        @endif
        
        <!-- Product Features -->
        @if($product->features && count($product->features) > 0)
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Key <span class="gradient-text">Features</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover what makes this product stand out from the competition.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($product->features as $feature)
                <div class="feature-card blur-card bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $feature->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $feature->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Testimonials -->
        @if($product->testimonials && count($product->testimonials) > 0)
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    What <span class="gradient-text">Users Say</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Hear from satisfied customers who have experienced the product firsthand.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($product->testimonials as $testimonial)
                <div class="testimonial-card blur-card bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $testimonial->rating)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 italic">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold mr-3">
                            {{ substr($testimonial->author_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $testimonial->author_name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $testimonial->author_title }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Similar Products -->
        @if(count($similarProducts) > 0)
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Similar <span class="gradient-text">Products</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Explore other products you might find interesting based on this selection.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($similarProducts as $similarProduct)
                    <div class="blur-card bg-white/60 dark:bg-gray-800/60 rounded-xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 group transition-all hover:shadow-xl hover:-translate-y-2">
                        <div class="relative aspect-video overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 transform scale-105 group-hover:scale-100 transition-transform duration-500"></div>
                            @if($similarProduct->image_path)
                                <img src="{{ Storage::url($similarProduct->image_path) }}" alt="{{ $similarProduct->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-200 to-purple-200 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <div class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    ${{ number_format($similarProduct->mrr, 0) }} /mo
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                @if($similarProduct->creator->profile_picture_path)
                                    <img src="{{ Storage::url($similarProduct->creator->profile_picture_path) }}" alt="{{ $similarProduct->creator->name }}" class="w-6 h-6 rounded-full mr-2 object-cover">
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold mr-2">
                                        {{ substr($similarProduct->creator->name, 0, 1) }}
                                    </div>
                                @endif
                                <a href="{{ route('creator.profile', $similarProduct->creator) }}" class="text-xs text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $similarProduct->creator->name }}
                                </a>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $similarProduct->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">{{ $similarProduct->description }}</p>
                            
                            <a href="{{ route('products.show', $similarProduct) }}" class="inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium text-sm">
                                View details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- CTA Banner -->
        <div class="mb-20">
            <div class="blur-card bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-2xl p-10 text-white shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjxwYXRoIGQ9Ik0xNiA0YzAgMi4yIDEuOCA0IDQgNHM0LTEuOCA0LTQtMS44LTQtNC00LTQgMS44LTQgNHoiLz48cGF0aCBkPSJNNDAgMjRjMCAyLjIgMS44IDQgNCA0czQtMS44IDQtNC0xLjgtNC00LTQtNCAxLjgtNCA0eiIvPjwvZz48L2c+PC9zdmc+')] opacity-40"></div>
                <div class="relative z-10">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold mb-4">Ready to try {{ $product->name }}?</h2>
                        <p class="text-white/80 max-w-2xl mx-auto mb-8">
                            Join thousands of satisfied users and experience the difference today.
                        </p>
                        <a href="{{ $product->website_url }}" target="_blank" rel="noopener noreferrer" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all pulse-animation">
                            Get Started Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 