<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        // Find the first user
        $creator = User::first();
        
        // Count all creators
        $creatorsCount = User::count();
        
        // Count all products
        $productsCount = Product::count();
        
        // Calculate total MRR
        $totalMrr = Product::sum('mrr');

        if (!$creator) {
            // Handle case where no user exists
            return view('welcome', [
                'creator' => null,
                'products' => collect(),
                'creatorsCount' => $creatorsCount,
                'productsCount' => $productsCount,
                'totalMrr' => $totalMrr,
            ]);
        }

        // Get products or return empty collection if none exist
        $products = $creator->products()->orderBy('created_at', 'desc')->get();

        // Pass the data to the view
        return view('welcome', compact('creator', 'products', 'creatorsCount', 'productsCount', 'totalMrr'));
    }
}
