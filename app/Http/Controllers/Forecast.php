<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Forecast extends Controller
{
    public function getForecast(Request $request)
    {
        // Ambil nilai 'days' dari request, default ke 30 jika tidak ada
        $days = $request->input('days', 30);

        // Panggil API eksternal dengan jumlah hari yang dipilih
        $response = Http::get("http://127.0.0.1:5000/bitcoin_forecast/{$days}");
        $data = $response->json();

        // Kirimkan data ramalan dan jumlah hari yang dipilih ke view
        return view('bitcoin_forecast', [
            'forecast' => $data,
            'selectedDays' => $days
        ]);
    }
}
