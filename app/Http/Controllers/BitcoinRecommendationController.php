<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BitcoinRecommendationController extends Controller
{
    public function getRecommendation(Request $request)
    {
        $depositFiat = $request->input('deposit_fiat');
        $bitcoin = $request->input('bitcoin');
        $buyDate = $request->input('buy_date');

        // Panggil API eksternal
        $response = Http::get('http://127.0.0.1:5000/bitcoin_buy_recommendation');
        $data = $response->json();

        // Ambil data dari respons API
        $recommendation = $data['recommendation'];
        $reason = $data['reason'];
        $currentPrice = $data['current_price'];
        $ma50 = $data['MA50'];
        $ma200 = $data['MA200'];
        $date = $data['date'];

        return view('bitcoin_recommendation', compact('recommendation', 'reason', 'currentPrice', 'ma50', 'ma200', 'date'));
    }
}
