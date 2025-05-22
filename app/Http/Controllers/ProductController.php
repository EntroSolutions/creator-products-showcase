<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('creator', 'tags');
        
        // Get search term
        $searchTerm = $request->input('search');

        // Filter by search term if provided
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
                  // Optionally search in tags or creator names too
                  // ->orWhereHas('tags', function($tagQuery) use ($searchTerm) {
                  //     $tagQuery->where('name', 'like', "%{$searchTerm}%");
                  // })
                  // ->orWhereHas('creator', function($creatorQuery) use ($searchTerm) {
                  //     $creatorQuery->where('name', 'like', "%{$searchTerm}%");
                  // });
            });
        }

        // Filter by tag if provided
        if ($request->has('tag')) {
            $tagSlug = $request->tag;
            $query->whereHas('tags', function($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        }
        
        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();
            
        // Get all tags with product count for the filter
        $allTags = Tag::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();
        
        // Get popular tags (top 5) for the quick filter
        $popularTags = $allTags->take(5);
        
        // Pass search term back to the view
        return view('products.index', compact('products', 'allTags', 'popularTags', 'searchTerm'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        // Get similar products (products with at least one matching tag)
        $similarProducts = Product::where('id', '!=', $product->id)
            ->whereHas('tags', function($query) use ($product) {
                $query->whereIn('tags.id', $product->tags->pluck('id'));
            })
            ->limit(3)
            ->get();
            
        return view('products.show', compact('product', 'similarProducts'));
    }
}
