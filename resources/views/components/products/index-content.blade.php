@props(['products', 'allTags', 'popularTags'])

<!-- Page Header -->
<div class="mb-12 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
        Discover <span class="gradient-text">Premium</span> Digital Products
    </h1>
    <p class="max-w-3xl mx-auto text-lg text-gray-700 dark:text-gray-300 mb-8">
        Browse through our collection of high-quality digital products created by talented individuals.
    </p>
    
    <!-- Search and Filter Section -->
    <div class="max-w-3xl mx-auto mb-10">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="search-input w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            </div>
            <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-medium">
                Search
            </button>
        </form>
    </div>
    
    <!-- Popular Tags -->
    @if($popularTags->isNotEmpty())
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('products.index') }}" class="tag-filter {{ !request('tag') ? 'active' : 'bg-white/70 dark:bg-gray-800/70' }} px-4 py-2 rounded-full text-sm font-medium border border-gray-200 dark:border-gray-700 transition-all">
                    All
                </a>
                @foreach($popularTags as $tag)
                    <a href="{{ route('products.index', ['tag' => $tag->slug]) }}" class="tag-filter {{ request('tag') == $tag->slug ? 'active' : 'bg-white/70 dark:bg-gray-800/70' }} px-4 py-2 rounded-full text-sm font-medium border border-gray-200 dark:border-gray-700 transition-all">
                        {{ $tag->name }} ({{ $tag->products_count }})
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Products Grid -->
<div class="mb-16">
    @if($products->isNotEmpty())
        <div class="product-grid">
            @foreach($products as $product)
                <div class="card-hover bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 group">
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
                            <div class="flex items-center">
                                @if($product->creator)
                                    <a href="{{ route('creator.profile', $product->creator) }}" class="flex items-center hover:text-blue-500 transition-colors">
                                        @if($product->creator->profile_picture_path)
                                            <img src="{{ Storage::url($product->creator->profile_picture_path) }}" alt="{{ $product->creator->name }}" class="w-6 h-6 rounded-full mr-2">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold mr-2">
                                                {{ substr($product->creator->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $product->creator->name }}</span>
                                    </a>
                                @endif
                            </div>
                            
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white/80 dark:bg-gray-800/80 blur-card rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 p-10 text-center">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Products Found</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto mb-6">
                We couldn't find any products matching your criteria. Try adjusting your search or filters, or check back later.
            </p>
            
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn-primary inline-block py-3 px-6 text-white font-semibold rounded-xl">
                    View All Products
                </a>
            </div>
        </div>
    @endif
</div>

<!-- All Tags Section -->
@if($allTags->isNotEmpty())
    <div class="mb-24">
        <div class="blur-card bg-white/80 dark:bg-gray-800/80 rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 p-10">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Browse By Category</h2>
                <p class="text-gray-600 dark:text-gray-400">Find products by specific categories or technologies</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($allTags as $tag)
                    <a href="{{ route('products.index', ['tag' => $tag->slug]) }}" 
                       class="tag-filter bg-white/70 dark:bg-gray-800/70 px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 dark:border-gray-700 transition-all tag-cloud-item"
                       style="--rotate: {{ rand(-5, 5) }}; --float: {{ rand(0, 10) / 10 }}; --delay: {{ rand(0, 10) / 10 }}">
                        {{ $tag->name }} ({{ $tag->products_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- CTA Section -->
<section class="mb-24 relative">
    <div class="blur-card bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-2xl p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjxwYXRoIGQ9Ik0xNiA0YzAgMi4yIDEuOCA0IDQgNHM0LTEuOCA0LTQtMS44LTQtNC00LTQgMS44LTQgNHoiLz48cGF0aCBkPSJNNDAgMjRjMCAyLjIgMS44IDQgNCA0czQtMS44IDQtNC0xLjgtNC00LTQtNCAxLjgtNCA0eiIvPjwvZz48L2c+PC9zdmc+')] opacity-40"></div>
        <div class="relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Are You a Creator?</h2>
                <p class="text-lg text-white/80 mb-8">
                    Join our platform to showcase your digital products and connect with potential customers.
                </p>
                <a href="/dashboard" class="inline-block py-3 px-8 bg-white hover:bg-gray-100 text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 pulse-animation">
                    Join as Creator
                </a>
            </div>
        </div>
    </div>
</section> 