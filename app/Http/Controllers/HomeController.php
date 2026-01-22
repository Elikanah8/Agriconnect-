<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Good practice to include this at the top

class HomeController extends Controller
{
    public function farmerDashboard()
    {
        // 1. Fetch products belonging ONLY to the logged-in farmer
        $products = Product::where('user_id', auth()->id())->latest()->get();

        // 2. Send the $products variable to the view using compact()
        return view('farmer_dashboard', compact('products'));
    }
}