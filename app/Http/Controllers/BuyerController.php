<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Display a listing of all available crops for the Buyer.
     */
    public function index()
    {
        $products = Product::all();
        return view('buyer_dashboard', compact('products'));
    }

    /**
     * The "Trigger": This creates the order that the Transporter will see.
     */
    public function placeOrder(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // 1. Create the Order in the database
        Order::create([
            'product_id' => $product->id,
            'buyer_id'   => Auth::id(),
            'farmer_id'  => $product->user_id, // Link to the farmer who owns it
            'quantity'   => $request->quantity ?? 1,
            'total_price'=> $product->price * ($request->quantity ?? 1),
            'status'     => 'pending', // This makes it visible to Transporters!
        ]);

        // 2. Redirect with a success message
        return redirect()->route('buyer.dashboard')->with('success', 'Order placed! A transporter will claim it soon.');
    }
}