<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Main redirect logic based on User Role.
     */
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

    /**
     * FARMER LOGIC: View own products and incoming orders.
     */
    public function farmerDashboard()
    {
        $products = Product::where('user_id', auth()->id())->latest()->get();
        
        // Orders where the product belongs to this farmer
        $orders = Order::where('farmer_id', auth()->id())
                       ->with(['product', 'buyer'])
                       ->latest()
                       ->get();

        return view('farmer_dashboard', compact('products', 'orders'));
    }

    /**
     * BUYER LOGIC: Search products and view marketplace.
     */
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

    /**
     * PRODUCT DETAILS: View single product info.
     */
    public function showProduct(Product $product)
    {
        $product->load('user'); 
        return view('product_details', compact('product'));
    }

    /**
     * ORDER LOGIC: Allow buyers to place an order.
     */
    public function placeOrder(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        Order::create([
            'product_id' => $product->id,
            'buyer_id' => auth()->id(),
            'farmer_id' => $product->user_id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Order placed successfully! The farmer has been notified.');
    }

    /**
     * TRANSPORTER LOGIC: View orders that are 'accepted' and ready for delivery.
     */
    public function transporterDashboard()
    {
        // Transporters see orders that are accepted by the farmer but not yet delivered
        $availableJobs = Order::where('status', 'accepted')
                              ->with(['product', 'buyer', 'farmer'])
                              ->latest()
                              ->get();

        return view('transporter_dashboard', compact('availableJobs'));
    }
}