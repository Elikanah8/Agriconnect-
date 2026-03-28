<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransporterController extends Controller
{
    /**
     * Show available delivery jobs and currently accepted jobs.
     */
    public function dashboard()
    {
        // 1. Available Gigs: Orders with no transporter yet.
        // We use 'with' to fetch related product and buyer info for the UI.
        $availableOrders = Order::whereNull('transporter_id')
                                ->where('status', 'pending')
                                ->with(['product', 'buyer']) 
                                ->get();

        // 2. My Active Jobs: Orders ALREADY claimed by this driver.
        $myActiveJobs = Order::where('transporter_id', Auth::id())
                             ->where('status', '!=', 'delivered')
                             ->with(['product', 'buyer'])
                             ->get();

        return view('transporter_dashboard', compact('availableOrders', 'myActiveJobs'));
    }

    /**
     * Claim an order for delivery.
     */
    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Safety Check: Ensure another driver hasn't already taken it
        if ($order->transporter_id !== null) {
            return back()->with('error', 'Sorry, this order has already been claimed!');
        }

        // Assign the current logged-in user as the transporter
        $order->update([
            'transporter_id' => Auth::id(),
            'status' => 'accepted' 
        ]);

        return back()->with('success', 'Order #'.$id.' accepted! Delivery details are now in your Active Jobs.');
    }
}