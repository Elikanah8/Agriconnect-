<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function farmerDashboard()
    {
        // This renders the page where your new form lives
        return view('farmer_dashboard');
    }
}