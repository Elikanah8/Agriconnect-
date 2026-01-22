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

    // --- BUYER LOGIC (Now inside the class!) ---
    public function buyerDashboard()
    {
        // The buyer needs to see ALL products available for sale
        $products = Product::latest()->get();

        return view('buyer_dashboard', compact('products'));
    }
}