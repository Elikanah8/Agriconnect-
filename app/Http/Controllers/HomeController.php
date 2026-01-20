<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function farmerDashboard()
    {
        return view('farmer_dashboard'); // This must match your .blade.php filename
    }
}