<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-financial@1.1.1/dist/chartjs-chart-financial.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0/dist/chartjs-adapter-date-fns.min.js"></script>
    <title>Bitcoin Price Forecast</title>
    <style>
        .chart-container {
            position: relative;
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-center text-indigo-600">Bitcoin Price Forecast</h1>

                <!-- Dropdown for time period -->
        <!-- Dropdown for time period -->
        <div class="mb-6 flex justify-center">
            <form id="filterForm" method="GET" action="{{ url('/forecast') }}">
                <label for="timePeriod" class="mr-4 text-lg font-medium">Select Time Period:</label>
                <select id="timePeriod" name="days" class="p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="30" {{ $selectedDays == 30 ? 'selected' : '' }}>1 Month</option>
                    <option value="90" {{ $selectedDays == 90 ? 'selected' : '' }}>3 Months</option>
                    <option value="180" {{ $selectedDays == 180 ? 'selected' : '' }}>6 Months</option>
                    <option value="365" {{ $selectedDays == 365 ? 'selected' : '' }}>1 Year</option>
                    <option value="all" {{ $selectedDays == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
                <button type="submit" id="filterButton" class="ml-4 bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700">Apply Filter</button>
            </form>
        </div>


        <!-- Display summary statistics -->
        @if(isset($forecast) && count($forecast) > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">Summary Statistics</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Total Days Forecasted</h3>
                        <p class="text-gray-700 text-2xl">{{ count($forecast) }}</p>
                    </div>
                    <div class="bg-green-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Average Predicted Price</h3>
                        <p class="text-gray-700 text-2xl">$ {{ number_format(array_sum(array_column($forecast, 'predicted_price')) / count($forecast), 2) }}</p>
                    </div>
                    <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Highest Predicted Price</h3>
                        <p class="text-gray-700 text-2xl">$ {{ number_format(max(array_column($forecast, 'predicted_price')), 2) }}</p>
                    </div>
                    <div class="bg-red-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">Lowest Predicted Price</h3>
                        <p class="text-gray-700 text-2xl">$ {{ number_format(min(array_column($forecast, 'predicted_price')), 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Display forecast data -->  
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('forecastChart').getContext('2d');
                    const forecastData = @json($forecast);
        
                    const labels = forecastData.map(item => item.date);
                    const prices = forecastData.map(item => item.predicted_price);
        
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Predicted Bitcoin Price',
                                data: prices,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `Predicted Price: ${context.parsed.y.toFixed(2)}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    },
                                    ticks: {
                                        maxRotation: 45,
                                        minRotation: 30,
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Price (USD)'
                                    },
                                    beginAtZero: false,
                                    ticks: {
                                        callback: function(value) {
                                            return `${value}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    });
                </script>
                <div class="chart-container mb-8">
                    <canvas id="forecastChart"></canvas>
                </div>

            <ul class="list-disc pl-5">
                @foreach($forecast as $item)
                    <li class="mb-3 flex justify-between text-lg">
                        <span class="font-semibold">{{ $item['date'] }}</span>
                        <span>${{ number_format($item['predicted_price'], 2) }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-red-600 text-center text-lg">No forecast data available.</p>
        @endif

        <!-- Back button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out">Back to Home</a>
        </div>
    </div>

</body>
</html>