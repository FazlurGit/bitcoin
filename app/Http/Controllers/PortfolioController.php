<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        // Fetch portfolio data from the database or session
        // Return the portfolio view with data
        return view('portfolio.index');
    }

    public function add(Request $request)
    {
        // Validate and add asset to the portfolio
        // Store in the database or session
        return redirect('/portfolio')->with('success', 'Asset added to portfolio!');
    }

    public function remove(Request $request)
    {
        // Validate and remove asset from the portfolio
        // Remove from the database or session
        return redirect('/portfolio')->with('success', 'Asset removed from portfolio!');
    }
}
