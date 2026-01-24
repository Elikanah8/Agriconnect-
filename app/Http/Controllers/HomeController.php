<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class HomeController extends Controller
{
    // --- FARMER LOGIC ---
    public function farmerDashboard()
    {
        // Fetch products belonging ONLY to the logged-in farmer
        $products = Product::where('user_id', auth()->id())->latest()->get();

        return view('farmer_dashboard', compact('products'));
    }

    // --- BUYER LOGIC ---
    public function buyerDashboard()
    {
        // The buyer needs to see ALL products available for sale
        $products = Product::latest()->get();

        return view('buyer_dashboard', compact('products'));
    }

    // --- NEW: PRODUCT DETAILS LOGIC ---
    public function showProduct(Product $product)
    {
        // 'load' gets the info of the farmer (user) who owns the product
        $product->load('user'); 
        
        return view('product_details', compact('product'));
    }
}