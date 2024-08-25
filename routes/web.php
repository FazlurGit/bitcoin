<?php
use App\Http\Controllers\BitcoinRecommendationController;
use App\Http\Controllers\Forecast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PriceAlertController;

Route::get('/', function () {
    return view('Test');
});

Route::get('/recommendation', [PythonController::class, 'getRecommendation']);
Route::get('/plot', [PythonController::class, 'plotGraph']);

Route::get('/recommendations', [BitcoinRecommendationController::class, 'getRecommendation']);
Route::get('/forecast', [Forecast::class, 'getForecast']);
Route::get('/bitcoin_forecast', [Forecast::class, 'getForecast']);

// Portfolio routes
Route::get('/portfolio', [PortfolioController::class, 'index']);
Route::post('/portfolio/add', [PortfolioController::class, 'add']);
Route::post('/portfolio/remove', [PortfolioController::class, 'remove']);

// Price Alert routes
Route::get('/price-alerts', [PriceAlertController::class, 'index']);
Route::post('/price-alerts/set', [PriceAlertController::class, 'set']);
Route::post('/price-alerts/remove', [PriceAlertController::class, 'remove']);
Route::get('/price-alerts', [PriceAlertController::class, 'index'])->name('price-alerts.index');
