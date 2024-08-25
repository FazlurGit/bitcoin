<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class PythonController extends Controller
{
    public function getRecommendation(Request $request)
    {
        $deposit_fiat = $request->input('deposit_fiat');
        $bitcoin = $request->input('bitcoin');
        $buy_date = $request->input('buy_date');

        // Run the Python script to get recommendation
        $output = Process::run("python resources/python/app.py {$deposit_fiat} {$bitcoin} {$buy_date}");

        if ($output->exitCode() === 0) {
            $recommendation = trim($output->output());
        } else {
            $recommendation = 'Error: ' . trim($output->errorOutput());
        }

        return view('welcome', [
            'recommendation' => $recommendation
        ]);
    }

    public function plotGraph()
    {
        // Run the Python script to generate and save the plot
        Process::run('python resources/python/graf.prec.py');

        // Get the path to the saved plot
        $plotPath = 'resources/python/historical_and_predicted.png';

        return view('welcome', [
            'plotPath' => $plotPath
        ]);
    }
}
