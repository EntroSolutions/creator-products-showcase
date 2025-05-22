<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CreatorController extends Controller
{
    /**
     * Display a listing of creators.
     */
    public function index(): View
    {
        $creators = User::withCount('products')
            ->withSum('products', 'mrr as total_mrr')
            ->paginate(12);
            
        return view('creator.index', compact('creators'));
    }

    /**
     * Display the specified creator's profile.
     */
    public function show(User $creator): View
    {
        // Load the creator's products
        $products = $creator->products()
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('creator.profile', compact('creator', 'products'));
    }
} 