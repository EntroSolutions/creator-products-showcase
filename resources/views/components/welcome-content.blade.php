@props(['creator', 'products', 'creatorsCount', 'productsCount', 'totalMrr'])

<!-- Creator Profile Hero Section -->
<section class="mb-24">
    @if($creator)
    <div class="blur-card bg-white/70 dark:bg-gray-800/70 rounded-2xl overflow-hidden shadow-xl border border-gray-200 dark:border-gray-700 mb-16">
        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row gap-12 items-center lg:items-start">
                <!-- Creator Avatar -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-md opacity-70 -z-10 scale-90"></div>
                    @if($creator->profile_picture_path)
                        <div class="w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden image-shimmer border-4 border-white dark:border-gray-700 shadow-xl">
                            <img src="{{ Storage::url($creator->profile_picture_path) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover image-zoom">
                        </div>
                    @else
                        <div class="w-32 h-32 md:w-48 md:h-48 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-4xl md:text-6xl font-bold border-4 border-white dark:border-gray-700 shadow-xl">
                            {{ substr($creator->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <!-- Creator Info -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-3">{{ $creator->name }}</h1>
                    
                    @if($creator->specialty)
                        <p class="text-xl text-blue-600 dark:text-blue-400 mb-6">{{ $creator->specialty }}</p>
                    @endif
                    
                    <div class="mb-8">
                        <p class="text-lg text-gray-700 dark:text-gray-300">{{ $creator->bio ?? 'A passionate creator committed to building innovative digital products.' }}</p>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="stat-card p-4 text-center">
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $products->count() }}</p>
                            <p class="text-gray-600 dark:text-gray-400">Products</p>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($products->sum('mrr'), 0) }}</p>
                            <p class="text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <p class="text-4xl font-bold text-green-600 dark:text-green-400">
                                @if(!is_null($creator->years_experience))
                                    {{ $creator->years_experience }}+
                                @else
                                    {{ max(0, round((time() - strtotime($creator->created_at)) / (60 * 60 * 24 * 365))) }}+
                                @endif
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">Years Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Fallback content when no creator exists - uses settings from the database -->
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
            Welcome to <span class="gradient-text">{{ setting('site_name', 'Creator Showcase') }}</span>
        </h1>
        <p class="max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300 mb-8">
            {{ setting('site_description', 'This platform showcases a talented creator and their impressive collection of digital products.') }}
        </p>
        <p class="max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300 mb-8">
            {{ setting('creator_intro', 'We feature talented creators and their impressive digital products.') }}
        </p>
        
        <!-- Contact button when no creator is present -->
        <a href="mailto:{{ setting('contact_email') }}" class="btn-primary inline-block py-3 px-8 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
            Get In Touch
        </a>
    </div>
    @endif
</section>

<!-- Product Showcase Section -->
<section class="mb-24">
    <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
            @if($creator)
                {{ setting('creator_tagline', 'Digital Products by') }} {{ $creator->name }}
            @else
                Featured Digital Products
            @endif
        </h2>
        <p class="max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300">
            @if($creator)
                Browse through a collection of high-quality digital products built with passion and expertise.
            @else
                Discover innovative digital products created by talented individuals from our platform.
            @endif
        </p>
    </div>
    
    @if($products && $products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="card-hover bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 group">
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
                        
                        @if($product->mrr)
                            <div class="absolute top-4 right-4">
                                <div class="bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    ${{ number_format($product->mrr, 0) }} /mo
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>
                        
                        <div class="flex justify-between items-center">
                            @if($product->tags && $product->tags->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->tags as $tag)
                                        <span class="tag text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-full">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" class="btn-primary py-3 px-8 rounded-xl text-white font-semibold transform transition-all hover:-translate-y-1 inline-block">
                View All Products
            </a>
        </div>
    @else
        <!-- If no products, show a message about upcoming products -->
        <div class="bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 p-10 text-center">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Products Coming Soon</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto mb-6">
                @if($creator)
                    {{ $creator->name }} is working on some amazing digital products. Check back soon to see what's being developed.
                @else
                    Our creators are working on some amazing digital products. Check back soon to see what's being developed.
                @endif
            </p>
        </div>
    @endif
</section>

<!-- CTA Section -->
<section class="mb-24 relative">
    <div class="blur-card bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-2xl p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjxwYXRoIGQ9Ik0xNiA0YzAgMi4yIDEuOCA0IDQgNHM0LTEuOCA0LTQtMS44LTQtNC00LTQgMS44LTQgNHoiLz48cGF0aCBkPSJNNDAgMjRjMCAyLjIgMS44IDQgNCA0czQtMS44IDQtNC0xLjgtNC00LTQtNCAxLjgtNCA0eiIvPjwvZz48L2c+PC9zdmc+')] opacity-40"></div>
        <div class="relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    @if($creator)
                        Ready to Work with {{ $creator->name }}?
                    @else
                        Interested in Learning More?
                    @endif
                </h2>
                <p class="text-lg text-white/80 mb-8">
                    @if($creator)
                        Get in touch to discuss collaboration opportunities or learn more about the available products and services.
                    @else
                        Connect with us to learn more about our upcoming creator showcase and digital products.
                    @endif
                </p>
                <!-- Contact link: always uses settings email -->
                <a href="mailto:{{ setting('contact_email') }}" class="inline-block py-3 px-8 bg-white hover:bg-gray-100 text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 pulse-animation">
                    {{ $creator ? 'Contact Now' : 'Register Interest' }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Debug Section -->
@if(config('app.debug'))
    <section class="mt-16 bg-gray-800 text-white p-6 rounded-lg">
        <!-- ... existing code ... -->
    </section>
@endif 