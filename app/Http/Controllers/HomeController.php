<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order; // Ensure this is imported

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

    // --- BUYER LOGIC (SEARCH & FILTER) ---
    public function buyerDashboard(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();

        return view('buyer_dashboard', compact('products'));
    }

    // --- PRODUCT DETAILS ---
    public function showProduct(Product $product)
    {
        $product->load('user'); 
        return view('product_details', compact('product'));
    }

    // --- ORDER LOGIC (Added inside the class) ---
    public function placeOrder(Request $request, Product $product)
    {
        // 1. Validate that the buyer isn't buying more than what is available
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        // 2. Create the order in the database
        Order::create([
            'product_id' => $product->id,
            'buyer_id' => auth()->id(),
            'farmer_id' => $product->user_id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'pending',
        ]);

        // 3. Redirect back with a success message for the UI
        return back()->with('success', 'Order placed successfully! The farmer has been notified.');
    }
} // This is the closing bracket for the Class - keep everything above it!