<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class HomeController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'farmer') {
            return redirect()->route('farmer.dashboard');
        } elseif ($role === 'buyer') {
            return redirect()->route('buyer.dashboard');
        } elseif ($role === 'transporter') {
            return redirect()->route('transporter.dashboard');
        }

        return redirect('/');
    }

    // --- FARMER LOGIC ---
    public function farmerDashboard()
    {
        $products = Product::where('user_id', auth()->id())->latest()->get();
        return view('farmer_dashboard', compact('products'));
    }

    // --- BUYER LOGIC (UPDATED FOR SEARCH) ---
    public function buyerDashboard(Request $request) // Added Request $request
    {
        // Start a query but don't "get" the results yet
        $query = Product::query();

        // If the buyer typed something in the search box
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // If the buyer picked a category from the dropdown
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Now finalize the query and get the products
        $products = $query->latest()->get();

        return view('buyer_dashboard', compact('products'));
    }

    // --- PRODUCT DETAILS LOGIC ---
    public function showProduct(Product $product)
    {
        $product->load('user'); 
        return view('product_details', compact('product'));
    }
}