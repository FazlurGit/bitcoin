<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceAlertController extends Controller
{
    public function index()
    {
        // Fetch price alerts from the database or session
        // Return the price alerts view with data
        return view('price-alerts.index');
    }

    public function set(Request $request)
    {
        // Validate and set a new price alert
        // Store in the database or session
        return redirect('/price-alerts')->with('success', 'Price alert set!');
    }

    public function remove(Request $request)
    {
        // Validate and remove a price alert
        // Remove from the database or session
        return redirect('/price-alerts')->with('success', 'Price alert removed!');
    }
}
