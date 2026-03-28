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
        $availableOrders = Order::whereNull('transporter_id')
                                ->where('status', 'pending')
                                ->with(['product', 'buyer']) 
                                ->get();

        // 2. My Active Jobs: Orders ALREADY claimed by this driver.
        $myActiveJobs = Order::where('transporter_id', Auth::id())
                             ->where('status', 'accepted')
                             ->with(['product', 'buyer'])
                             ->get();

        return view('transporter_dashboard', compact('availableOrders', 'myActiveJobs'));
    }

    /**
     * Step 1: Claim an order for delivery.
     */
    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Safety Check: Ensure another driver hasn't already taken it
        if ($order->transporter_id !== null) {
            return back()->with('error', 'Sorry, this order has already been claimed!');
        }

        $order->update([
            'transporter_id' => Auth::id(),
            'status' => 'accepted' 
        ]);

        return back()->with('success', 'Order #' . $id . ' accepted! Get moving!');
    }

    /**
     * Step 2: Mark delivery as finished.
     */
    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);

        // Security Check: Ensure only the assigned driver can complete the order
        if ($order->transporter_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $order->update([
            'status' => 'delivered'
        ]);

        return back()->with('success', 'Great job! Delivery confirmed and marked as complete.');
    }
}