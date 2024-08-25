<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Bitcoin Recommendation System</title>
    <style>
        /* Custom CSS for the chart container */
        .chart-container {
            width: 100%;
            height: 500px; /* Adjust height as needed */
        }
        /* Add margin to the button */
        .mt-4-custom {
            margin-top: 1rem; /* Adjust the margin as needed */
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Bitcoin Recommendation System</h1>

        <!-- Button to access Bitcoin Recommendations -->
        <a href="/recommendations" class="block mt-4-custom text-center w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Get Buy Recommendations Now
        </a>

        <!-- Dropdown for time period -->
        <div class="mb-6">
            <label for="timePeriod" class="block text-lg font-medium mb-2">Select Time Period:</label>
            <select id="timePeriod" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="30">1 Month</option>
                <option value="90">3 Months</option>
                <option value="180">6 Months</option>
                <option value="365" selected>1 Year</option>
                <option value="all">All Time</option>
            </select>
        </div>

        <!-- Container for the chart -->
        <div class="mt-6">
            <h2 class="font-bold text-lg">Bitcoin Price Plot:</h2>
            <div class="chart-container mt-2 rounded-md shadow-md">
                <canvas id="bitcoinPriceChart"></canvas>
            </div>
        </div>

        <!-- Button to access Bitcoin Forecast -->
        <a href="/forecast" class="block mt-4 text-center w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Get Bitcoin Forecast
        </a>

        <!-- Button to access Portfolio -->
        <a href="/portfolio" class="block mt-4 text-center w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            View Portfolio
        </a>

        <!-- Button to access Price Alerts -->
        <a href="/price-alerts" class="block mt-4 text-center w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
            Manage Price Alerts
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('bitcoinPriceChart').getContext('2d');
            const timePeriodSelect = document.getElementById('timePeriod');
            let chart;

            async function fetchData(days) {
                const response = await fetch(`http://127.0.0.1:5000/bitcoin_price?days=${days}`);
                const data = await response.json();

                const labels = data.map(item => item.date);
                const prices = data.map(item => item.close);

                return { labels, prices };
            }

            async function updateChart(days) {
                const { labels, prices } = await fetchData(days);

                if (chart) {
                    chart.destroy(); // Destroy the previous chart instance
                }

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Bitcoin Price',
                            data: prices,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Make sure the chart fills the container
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Price: $${context.raw.toFixed(2)}`;
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
                                        return `$${value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Initial chart load
            updateChart(365); // Default to 1 year

            // Event listener for dropdown change
            timePeriodSelect.addEventListener('change', function () {
                const days = timePeriodSelect.value;
                updateChart(days);
            });
        });
    </script>
</body>
</html>
