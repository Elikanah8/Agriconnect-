<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransporterController extends Controller
{
    public function dashboard()
    {
        // Show orders that don't have a transporter yet
        $availableOrders = Order::whereNull('transporter_id')->get();
        return view('transporter_dashboard', compact('availableOrders'));
    }

    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Assign the current logged-in user as the transporter
        $order->update([
            'transporter_id' => Auth::id(),
            'status' => 'accepted' 
        ]);

        return back()->with('success', 'Order accepted successfully! Get moving!');
    }
}